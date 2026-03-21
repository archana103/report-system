import axios from "axios";
import { z } from "zod";

/**
 * Zod schema
 */
export const loginSchema = z.object({
    email: z.string().email("Invalid email format"),
    password: z.string().min(1, "Password is required"),
});

/**
 * Validate form
 */
export const validateLogin = (form, errors) => {
    errors.email = "";
    errors.password = "";

    const result = loginSchema.safeParse(form);

    if (!result.success) {
        result.error.issues.forEach((err) => {
            if (err.path[0]) {
                errors[err.path[0]] = err.message;
            }
        });
        return false;
    }

    return true;
};

/**
 * Login API call
 */
export const loginRequest = async (form) => {
    return await axios.post("/admin/login", form);
};
