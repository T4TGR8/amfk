<?php
class ProgramRepository
{
    public static function normalizePrograms(array $programs, string $referenceTime = 'now'): array
    {
        $programs = array_map(function ($program) use ($referenceTime) {
            $status = self::calculateStatus($program, $referenceTime);

            return [
                'id' => $program['id'],
                'start_at' => $program['start_at'],
                'status' => $status,
                'status_label' => Status::label($status),
                'bookable' => self::isBookable($status),
                'location' => $program['location'],
                'title' => $program['title'],
                'difficulty' => $program['difficulty'],
                'price_huf' => $program['price_huf'],
                'available_places' => max(0, $program['capacity'] - $program['booked'])
            ];
        }, $programs);

        usort($programs, static function (array $a, array $b): int {
            // Bookable programs first.
            if ($a['bookable'] !== $b['bookable']) {
                return (int) $b['bookable'] <=> (int) $a['bookable'];
            }

            // Within each group, soonest start time first.
            return strcmp($a['start_at'], $b['start_at']);
        });

        return $programs;
    }

    private static function calculateStatus(array $program, string $referenceTime): string
    {
        require_once(__DIR__ . '/class-program-status.php');
        if (!empty($program['cancelled'])) {
            return Status::CANCELLED;
        }

        $start = new DateTimeImmutable($program['start_at']);
        $reference = new DateTimeImmutable($referenceTime);

        if ($start <= $reference) {
            return Status::FINISHED;
        }

        $capacity = (int) $program['capacity'];
        $booked = (int) $program['booked'];

        if ($capacity <= 0 || $booked < 0 || $booked > $capacity) {
            return Status::UNBOOKABLE;
        }

        $remaining = $capacity - $booked;

        if ($remaining === 0) {
            return Status::FULL;
        }

        if ($remaining <= $capacity * 0.20) {
            return Status::FEW_SPOTS;
        }

        return Status::AVAILABLE;
    }

    private static function isBookable(string $status): bool
    {
        return $status === Status::AVAILABLE || $status === Status::FEW_SPOTS;
    }
}