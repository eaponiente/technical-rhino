export interface Tag {
    id: number;
    name: string;
}

export interface Media {
    id: number;
    title: string;
    description: string;
    author: string;
    type: string;
    tags: Tag[];
}