export type ValidationError = {
    message: string;
    errors: {
        [key: string]: string[];
    };
};