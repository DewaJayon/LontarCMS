import { clsx } from "clsx";
import { twMerge } from "tailwind-merge";

export function cn(...inputs) {
    return twMerge(clsx(inputs));
}

export function valueUpdater(updaterOrValue, ref) {
    ref.value =
        typeof updaterOrValue === "function"
            ? updaterOrValue(ref.value)
            : updaterOrValue;
}

export function filterMenuByRole(menu, role) {
    return menu.filter((item) => item.roles.includes(role));
}
