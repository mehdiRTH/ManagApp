interface Link {
    url: string | null;
    label: string;
    active: boolean;
}

export interface MetaInterface{
     links:Link[]
}
