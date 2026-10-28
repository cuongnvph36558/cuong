export type Feedback = {
    id: number;
    name: string;
    role: string | null;
    rating: number;
    content: string;
    image: string | null;
    photos: string[] | null;
    is_featured: boolean;
    sort_order: number;
    created_at: string;
};
