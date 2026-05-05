<?php
/**
 * Form Validation Class
 * FixIt Smart Complaint Management System
 */

class FormValidator {
    /**
     * Validate registration form data
     */
    public static function validateRegistration($data) {
        $errors = [];

        // Validate name
        if (empty($data['name'])) {
            $errors['name'] = 'Full name is required';
        } elseif (strlen($data['name']) < 2) {
            $errors['name'] = 'Name must be at least 2 characters long';
        } elseif (strlen($data['name']) > 100) {
            $errors['name'] = 'Name must not exceed 100 characters';
        }

        // Validate email
        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address';
        }

        // Validate password
        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($data['password']) < 6) {
            $errors['password'] = 'Password must be at least 6 characters long';
        }

        // Validate confirm password
        if (empty($data['confirmPassword'])) {
            $errors['confirm_password'] = 'Please confirm your password';
        } elseif ($data['password'] !== $data['confirmPassword']) {
            $errors['confirm_password'] = 'Passwords do not match';
        }

        // Validate roll number
        if (empty($data['roll_number'])) {
            $errors['roll_number'] = 'Roll number is required';
        }

        // Validate department
        if (empty($data['department'])) {
            $errors['department'] = 'Please select a department';
        }

        return $errors;
    }

    /**
     * Validate login form data
     */
    public static function validateLogin($data) {
        $errors = [];

        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address';
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        }

        return $errors;
    }

    /**
     * Validate complaint form data
     */
    public static function validateComplaint($data) {
        $errors = [];

        if (empty($data['category'])) {
            $errors['category'] = 'Please select a category';
        }

        if (empty($data['title'])) {
            $errors['title'] = 'Title is required';
        } elseif (strlen($data['title']) < 5) {
            $errors['title'] = 'Title must be at least 5 characters long';
        } elseif (strlen($data['title']) > 200) {
            $errors['title'] = 'Title must not exceed 200 characters';
        }

        if (empty($data['description'])) {
            $errors['description'] = 'Description is required';
        } elseif (strlen($data['description']) < 10) {
            $errors['description'] = 'Description must be at least 10 characters long';
        }

        if (empty($data['priority'])) {
            $errors['priority'] = 'Please select a priority level';
        }

        return $errors;
    }

    /**
     * Validate contact form data
     */
    public static function validateContact($data) {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = 'Name is required';
        } elseif (strlen($data['name']) < 2) {
            $errors['name'] = 'Name must be at least 2 characters long';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address';
        }

        if (empty($data['subject'])) {
            $errors['subject'] = 'Subject is required';
        } elseif (strlen($data['subject']) < 3) {
            $errors['subject'] = 'Subject must be at least 3 characters long';
        }

        if (empty($data['message'])) {
            $errors['message'] = 'Message is required';
        } elseif (strlen($data['message']) < 10) {
            $errors['message'] = 'Message must be at least 10 characters long';
        }

        return $errors;
    }

    /**
     * Validate password change
     */
    public static function validatePasswordChange($data) {
        $errors = [];

        if (empty($data['current_password'])) {
            $errors['current_password'] = 'Current password is required';
        }

        if (empty($data['new_password'])) {
            $errors['new_password'] = 'New password is required';
        } elseif (strlen($data['new_password']) < 6) {
            $errors['new_password'] = 'New password must be at least 6 characters long';
        }

        if (empty($data['confirm_password'])) {
            $errors['confirm_password'] = 'Please confirm your new password';
        } elseif ($data['new_password'] !== $data['confirm_password']) {
            $errors['confirm_password'] = 'Passwords do not match';
        }

        return $errors;
    }
}
?>
