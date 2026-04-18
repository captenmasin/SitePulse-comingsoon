<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import ScreenshotMed from '@/images/screenshot-med.png';
import ScreenshotSmall from '@/images/screenshot-small.png';
import Screenshot from '@/images/screenshot.png';
import AppLogo from '@/js/components/AppLogo.vue';

// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-expect-error
import { store } from '@/js/routes/waitlist';

const page = usePage();
const form = useForm({
    email: '',
});
const successMessage = computed(() => page.props.flash.waitlist.success);

function submit() {
    form.post(store.url(), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <div
        class="min-h-screen bg-white font-sans text-neutral-950 antialiased dark:bg-neutral-950 dark:text-neutral-100"
    >
        <div class="mx-auto flex min-h-screen max-w-6xl flex-col px-6 md:px-10">
            <header class="flex items-center justify-between py-4 md:py-7">
                <a
                    href="/"
                    class="flex items-center gap-2.5 text-base font-semibold tracking-tight"
                >
                    <AppLogo class="w-32 md:w-36 dark:hidden" />
                    <AppLogo white class="hidden w-32 md:w-36 dark:flex" />
                </a>
                <span
                    class="inline-flex items-center gap-2 font-mono text-xs text-neutral-500 dark:text-neutral-400"
                >
                    <i
                        class="h-1.5 w-1.5 rounded-full bg-green-600 ring-2 ring-green-600/20 dark:bg-green-500 dark:ring-green-500/30"
                    />
                    Launching 2026
                </span>
            </header>

            <main class="grow pt-4 pb-16 md:py-20">
                <span
                    class="font-mono text-xs font-semibold tracking-widest text-neutral-500 uppercase dark:text-neutral-400"
                >
                    Coming soon
                </span>
                <h1 class="mt-5 font-sans text-5xl font-semibold text-pretty md:text-7xl lg:text-8xl lg:leading-[0.85]">
                    Monitor, fix, and
                    <em class="text-primary italic dark:text-primary">optimise</em>
                    your sites
                </h1>
                <p
                    class="mt-6 max-w-2xl leading-relaxed text-neutral-500 md:text-lg dark:text-neutral-400"
                >
                    Run SSL, DNS, uptime, broken-link and performance checks
                    across your whole site roster to ensure your sites stay in
                    the green.
                </p>

                <form
                    v-if="!successMessage"
                    novalidate
                    class="mt-9 max-w-md"
                    @submit.prevent="submit"
                >
                    <div
                        class="flex flex-col gap-1.5 rounded-xl border p-1.5 transition-colors focus-within:ring-4 sm:flex-row"
                        :class="
                            form.errors.email
                                ? 'border-rose-600 focus-within:ring-rose-600/10'
                                : 'border-neutral-200 focus-within:border-primary focus-within:ring-primary/10 dark:border-neutral-800 dark:focus-within:border-white dark:focus-within:ring-primary/15'
                        "
                    >
                        <input
                            v-model="form.email"
                            type="email"
                            inputmode="email"
                            autocomplete="email"
                            placeholder="you@company.com"
                            required
                            @input="form.clearErrors('email')"
                            class="min-w-0 flex-1 border-0 bg-transparent px-3 py-2.5 text-sm text-neutral-950 outline-none placeholder:text-neutral-500 dark:text-neutral-100 dark:placeholder:text-neutral-400"
                        />
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="cursor-pointer rounded-lg bg-neutral-950 px-4 py-2.5 text-sm font-medium whitespace-nowrap text-white transition-colors select-none hover:bg-primary dark:bg-white dark:text-neutral-950 dark:hover:bg-primary dark:hover:text-white"
                        >
                            {{
                                form.processing ? 'Joining...' : 'Join waitlist'
                            }}
                        </button>
                    </div>
                    <p
                        v-if="form.errors.email"
                        class="mt-2 text-sm text-rose-600 dark:text-rose-400"
                    >
                        {{ form.errors.email }}
                    </p>
                </form>

                <div
                    v-else
                    class="bordr-primary mt-7 max-w-md border-l-2 py-1 pl-3.5 text-sm leading-relaxed dark:border-primary"
                >
                    {{ successMessage }}
                </div>
            </main>

            <div
                class="relative flex aspect-2/1 items-center justify-center overflow-hidden rounded-sm border border-neutral-200 bg-neutral-50 text-neutral-200 md:rounded-2xl dark:border-neutral-800 dark:bg-neutral-900 dark:text-neutral-800"
                aria-label="Product screenshot placeholder"
            >
                <img
                    :src="ScreenshotMed"
                    :srcset="`
                        ${ScreenshotSmall}  480w,
                        ${ScreenshotMed}   1024w,
                        ${Screenshot}       1600w
                    `"
                    sizes="(max-width: 640px) 100vw,(max-width: 1024px) 100vw,1600px"
                    alt="SEO Toolkit dashboard showing website health checks"
                    class="size-full object-cover object-top"
                />
            </div>

            <footer
                class="mt-8 flex justify-between border-t border-neutral-200 py-8 text-xs text-neutral-500 dark:border-neutral-800 dark:text-neutral-400"
            >
                <span>© 2026 SpacemanCodes LTD</span>
            </footer>
        </div>
    </div>
</template>
