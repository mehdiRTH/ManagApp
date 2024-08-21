import { AnnounceInterface } from "./Announce/AnnounceInterface";
import { NotificationInterface } from "./Notification/NotificationInterface";

export interface User {
    role: any;
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        role: Array<string>;
        announces: AnnounceInterface;
        notifications: NotificationInterface;
        user: User;
        qrCode:string;
    };
};
