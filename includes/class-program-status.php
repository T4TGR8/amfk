<?php
class Status
{
    public const AVAILABLE = 'available';
    public const FEW_SPOTS = 'few_spots';
    public const FULL = 'full';
    public const CANCELLED = 'cancelled';
    public const FINISHED = 'finished';
    public const UNBOOKABLE = 'unbookable';

    public static function label(string $status): string
    {
        return match ($status) {
            self::AVAILABLE => 'Elérhető',
            self::FEW_SPOTS => 'Már csak néhány hely',
            self::FULL => 'Betelt',
            self::CANCELLED => 'Lemondva',
            self::FINISHED => 'Már lezajlott',
            self::UNBOOKABLE => 'Nem foglalható',
            default => 'Ismeretlen',
        };
    }
}