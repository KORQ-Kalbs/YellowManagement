<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class CaptchaService
{
    /**
     * Generate a new CAPTCHA challenge
     */
    public static function generate(): array
    {
        $operations = ['+', '-', '*'];
        $operation = $operations[array_rand($operations)];
        
        $num1 = rand(1, 50);
        $num2 = rand(1, 50);
        
        // For subtraction, ensure result is positive
        if ($operation === '-' && $num2 > $num1) {
            [$num1, $num2] = [$num2, $num1];
        }
        
        // Calculate answer
        $answer = match ($operation) {
            '+' => $num1 + $num2,
            '-' => $num1 - $num2,
            '*' => $num1 * $num2,
        };
        
        $question = "{$num1} {$operation} {$num2} = ?";
        
        // Store answer in session with expiration
        Session::put('captcha_answer', $answer);
        Session::put('captcha_expires_at', now()->addMinutes(10));
        
        return [
            'question' => $question,
            'session_id' => Session::getId(),
        ];
    }
    
    /**
     * Verify CAPTCHA answer
     */
    public static function verify(string|int $userAnswer): bool
    {
        // Check if CAPTCHA has expired
        if (!Session::has('captcha_answer') || !Session::has('captcha_expires_at')) {
            return false;
        }
        
        if (now()->isAfter(Session::get('captcha_expires_at'))) {
            Session::forget(['captcha_answer', 'captcha_expires_at']);
            return false;
        }
        
        $correctAnswer = (int) Session::get('captcha_answer');
        $userAnswer = (int) trim($userAnswer);
        
        $isValid = $userAnswer === $correctAnswer;
        
        // Clear CAPTCHA after verification attempt
        if ($isValid) {
            Session::forget(['captcha_answer', 'captcha_expires_at']);
        }
        
        return $isValid;
    }
    
    /**
     * Get CAPTCHA question from session
     */
    public static function getQuestion(): ?string
    {
        return Session::get('captcha_question');
    }
    
    /**
     * Clear CAPTCHA data
     */
    public static function clear(): void
    {
        Session::forget(['captcha_answer', 'captcha_expires_at', 'captcha_question']);
    }
}
