export type ProjectCard = {
    id: number;
    title: string;
    slug: string;
    summary: string;
    thumbnail: string | null;
    technologies: string[];
};

export type Project = ProjectCard & {
    case_study: string;
    solution: string;
    features: string[];
    screenshots: string[];
    github_url: string | null;
    demo_url: string | null;
    status: boolean;
    sort_order: number;
};

export type ProjectRow = {
    id: number;
    title: string;
    slug: string;
    thumbnail: string | null;
    status: boolean;
    sort_order: number;
};

export type Flash = {
    message: string | null;
    undoId: number | null;
};
