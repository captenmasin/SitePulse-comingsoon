import type { Auth } from '@/types/auth';

// Extend ImportMeta interface for Vite...
declare module 'vite/client' {
    interface ImportMetaEnv {
        readonly VITE_APP_NAME: string;
        [key: string]: string | boolean | undefined;
    }

    interface ImportMeta {
        readonly env: ImportMetaEnv;
        readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>;
    }
}

declare module '@inertiajs/core' {
    export interface InertiaConfig {
        sharedPageProps: {
            name: string;
            auth: Auth;
            flash: {
                waitlist: {
                    success: string | null;
                };
            };
            seo: {
                siteName: string;
                pageTitle: string;
                fullTitle: string;
                description: string;
                canonicalUrl: string;
                robots: string;
                ogImageUrl: string;
                ogImageAlt: string;
                ogImageWidth: number;
                ogImageHeight: number;
                twitterCard: string;
                structuredData: Record<string, unknown>;
            };
            sidebarOpen: boolean;
            [key: string]: unknown;
        };
    }
}

declare module 'vue' {
    interface ComponentCustomProperties {
        $inertia: typeof Router;
        $page: Page;
        $headManager: ReturnType<typeof createHeadManager>;
    }
}
