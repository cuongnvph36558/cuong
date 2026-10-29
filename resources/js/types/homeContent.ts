export type HomeContentScalar = string | number | null;

export type HomeContentItem = Record<string, HomeContentScalar>;

export type HomeContentSectionContent = Record<
    string,
    HomeContentScalar | HomeContentItem[]
>;

export type HomeContent = Record<string, HomeContentSectionContent>;

export type HomeContentImageItem = {
    title?: string;
    description?: string;
    quote?: string;
    author?: string;
    name?: string;
    time?: string;
    content?: string;
    image?: string;
    value?: string;
    stars?: number;
    percent?: number;
    price?: string;
    originalPrice?: string;
    discount?: string;
    badge?: string;
    saving?: string;
    gift?: string;
    stage?: string;
    dosage?: string;
    result?: string;
    resultImage?: string;
};

export type HomeContentListField = {
    key: string;
    label: string;
    type: 'text' | 'textarea' | 'number' | 'image' | 'list';
    default: unknown;
    itemLabel?: string;
    itemFields?: {
        key: string;
        label: string;
        type: string;
        default?: unknown;
    }[];
};

export type HomeContentField = HomeContentListField;

export type HomeContentSection = {
    key: string;
    label: string;
    icon: string;
    description: string;
    fields: HomeContentField[];
};
