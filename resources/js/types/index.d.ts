export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    role: number;
    profile_image?: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
