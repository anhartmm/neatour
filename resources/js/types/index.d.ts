import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    role: string;
    phone_number?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Category {
    id: number;
    name: string;
    img?: string;
    created_at: string;
    updated_at: string;
}

export interface Destination {
    id: string;
    name: string;
    thumb_image: string;
    content: string;
    facility: string;
    lat: number;
    lon: number;
    address?: string;
    operating_hours?: string;
    pic_id: number;
    avg_rating?: number;
    total_reviews?: number;
    distance?: number;
    published: boolean;
    created_at: string;
    updated_at: string;
    pic?: User;
    categories?: Category[];
    testimonials?: DestinationTestimonial[];
}

export interface DestinationTestimonial {
    id: string;
    destination_id: string;
    user_id: number;
    comment: string;
    rating: number;
    created_at: string;
    updated_at: string;
    user?: User;
}

export interface Testimonial {
    id: number;
    destination_id: string;
    name?: string;
    comment: string;
    rating: number;
    created_at: string;
    updated_at: string;
    destination?: Destination;
}

export type BreadcrumbItemType = BreadcrumbItem;
