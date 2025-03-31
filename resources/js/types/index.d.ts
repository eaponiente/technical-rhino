import type { PageProps } from '@inertiajs/core';
import type { Config } from 'ziggy-js';


export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    ziggy: Config & { location: string };
}

