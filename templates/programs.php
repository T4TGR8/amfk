<?php
/**
 * Programs template
 *
 * @var array $programs
 */
?>

<section class="hkm mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8" data-programs>
    <header class="mb-8 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">

        <div>
            <p class="mb-2 text-xs font-extrabold uppercase tracking-[0.15em] text-emerald-700">
                Hétvégi programok
            </p>

            <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                Hétvégi Kalandmentő
            </h2>

            <p class="mt-3 max-w-2xl text-base leading-7 text-slate-600">
                Találd meg a hétvégi programot, amire még érdemes jelentkezni.
            </p>
        </div>


        <div class="flex flex-col gap-3 sm:flex-row">

            <label class="flex flex-col gap-1">
                <span class="text-xs font-bold uppercase tracking-wide text-slate-500">
                    Szűrés
                </span>

                <select data-filter class="min-h-11 rounded-xl border border-slate-200 bg-white px-4
                           text-sm font-medium text-slate-900 shadow-sm outline-none
                           transition focus:border-emerald-600
                           focus:ring-4 focus:ring-emerald-600/10">
                    <option value="all">Minden program</option>
                    <option value="available">Foglalható</option>
                    <option value="not_available">Nem foglalható</option>
                </select>
            </label>

        </div>

    </header>


    <?php if (empty($programs)): ?>

        <div class="rounded-2xl border border-dashed border-slate-200 bg-white p-12 text-center">
            <p class="text-slate-500">
                Nincs megjeleníthető program.
            </p>
        </div>

    <?php else: ?>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3" data-program-list>

            <?php foreach ($programs as $program): ?>

                <?php
                $status_classes = match ($program['status']) {
                    'available' => 'bg-emerald-50 text-emerald-700',
                    'few_spots' => 'bg-amber-50 text-amber-700',
                    'full',
                    'finished',
                    'unbookable' => 'bg-slate-100 text-slate-600',
                    'cancelled' => 'bg-red-50 text-red-700',
                    default => 'bg-slate-100 text-slate-600',
                };

                $card_classes = $program['bookable']
                    ? ''
                    : 'opacity-70';

                $action_classes = $program['bookable']
                    ? 'bg-emerald-700 text-white hover:bg-emerald-800'
                    : 'cursor-not-allowed bg-slate-100 text-slate-500';

                $formatted_date = wp_date(
                    'Y. F j. H:i',
                    (new DateTimeImmutable($program['start_at']))->getTimestamp()
                );
                ?>

                <article class="<?= esc_attr($card_classes); ?> flex flex-col overflow-hidden
                           rounded-2xl border border-slate-200 bg-white shadow-sm
                           transition duration-200 hover:-translate-y-1 hover:shadow-lg" data-program
                    data-status="<?= esc_attr($program['status']); ?>" data-bookable="<?= $program['bookable'] ? '1' : '0'; ?>"
                    data-start="<?= esc_attr($program['start_at']); ?>"
                    data-places="<?= esc_attr($program['available_places']); ?>">

                    <!-- Header -->

                    <header class="flex items-start justify-between gap-4 p-5">

                        <div class="min-w-0">

                            <p class="mb-1 text-xs font-extrabold uppercase tracking-wider text-emerald-700">
                                <?= esc_html($program['location']); ?>
                            </p>

                            <h3 class="text-lg font-bold leading-snug text-slate-900">
                                <?= esc_html($program['title']); ?>
                            </h3>

                        </div>


                        <span class="<?= esc_attr($status_classes); ?> shrink-0 rounded-full
                                   px-2.5 py-1 text-xs font-bold">
                            <?= esc_html($program['status_label']); ?>
                        </span>

                    </header>


                    <!-- Details -->

                    <div class="grid grid-cols-2 border-y border-slate-100">

                        <div class="p-4">
                            <span class="mb-1 block text-[0.68rem] font-bold uppercase tracking-wide text-slate-400">
                                Időpont
                            </span>

                            <time datetime="<?= esc_attr($program['start_at']); ?>"
                                class="block text-sm font-semibold text-slate-800">
                                <?= esc_html($formatted_date); ?>
                            </time>
                        </div>


                        <div class="border-l border-slate-100 p-4">
                            <span class="mb-1 block text-[0.68rem] font-bold uppercase tracking-wide text-slate-400">
                                Nehézség
                            </span>

                            <span class="block text-sm font-semibold text-slate-800">
                                <?= !empty($program['difficulty'])
                                    ? esc_html(ucfirst($program['difficulty']))
                                    : '–';
                                ?>
                            </span>
                        </div>


                        <div class="border-t border-slate-100 p-4">
                            <span class="mb-1 block text-[0.68rem] font-bold uppercase tracking-wide text-slate-400">
                                Ár
                            </span>

                            <span class="block text-sm font-semibold text-slate-800">
                                <?php if ($program['price_huf'] > 0): ?>
                                    <?= esc_html(
                                        number_format(
                                            $program['price_huf'],
                                            0,
                                            ',',
                                            ' '
                                        )
                                    ); ?>
                                    Ft
                                <?php else: ?>
                                    Ingyenes
                                <?php endif; ?>
                            </span>
                        </div>


                        <?php if ($program['bookable']): ?>

                            <div class="border-l border-t border-slate-100 p-4">
                                <span class="mb-1 block text-[0.68rem] font-bold uppercase tracking-wide text-slate-400">
                                    Szabad helyek
                                </span>

                                <span class="block text-sm font-semibold text-slate-800">
                                    <?= esc_html($program['available_places']); ?>
                                </span>
                            </div>

                        <?php endif; ?>

                    </div>


                    <!-- Footer -->

                    <footer class="mt-auto p-4">

                        <?php if ($program['bookable']): ?>

                            <button type="button" class="hkm-card__action min-h-11 w-full rounded-xl px-4 py-2.5
                                       text-sm font-bold transition
                                       focus:outline-none focus:ring-4
                                       focus:ring-emerald-600/10
                                       bg-emerald-700 text-white
                                       hover:bg-emerald-800" data-program-id="<?= esc_attr($program['id']); ?>">
                                Jelentkezem
                            </button>

                        <?php else: ?>

                            <button type="button" disabled class="min-h-11 w-full cursor-not-allowed rounded-xl
                                       bg-slate-100 px-4 py-2.5 text-sm font-bold
                                       text-slate-500">
                                Nem foglalható
                            </button>

                        <?php endif; ?>

                    </footer>

                </article>

            <?php endforeach; ?>

        </div>


        <!-- Empty filter result -->

        <div data-no-results class="mt-6 hidden rounded-2xl border border-dashed
                   border-slate-200 bg-white p-10 text-center">
            <p class="text-slate-500">
                A kiválasztott szűrésnek nincs megfelelő program.
            </p>
        </div>

    <?php endif; ?>

</section>