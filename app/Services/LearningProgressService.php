<?php

namespace App\Services;

use App\Models\QuizAttempt;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

class LearningProgressService
{
    public const SUBMIT_BONUS_XP = 20;

    public const CORRECT_ANSWER_XP = 15;

    public const PERFECT_SCORE_BONUS_XP = 40;

    public const XP_PER_LEVEL = 120;

    public function xpForAttempt(int $correctAnswers, int $totalQuestions): int
    {
        $xp = self::SUBMIT_BONUS_XP + ($correctAnswers * self::CORRECT_ANSWER_XP);

        if ($totalQuestions > 0 && $correctAnswers === $totalQuestions) {
            $xp += self::PERFECT_SCORE_BONUS_XP;
        }

        return $xp;
    }

    /**
     * @return array{totalXp:int,level:int,currentStreak:int,longestStreak:int,attempts:int}
     */
    public function summaryForUser(User $user): array
    {
        $attempts = $user->quizAttempts()
            ->select(['id', 'xp_earned', 'submitted_at'])
            ->whereNotNull('submitted_at')
            ->orderByDesc('submitted_at')
            ->get();

        $totalXp = (int) $attempts->sum('xp_earned');

        return [
            'totalXp' => $totalXp,
            'level' => intdiv($totalXp, self::XP_PER_LEVEL) + 1,
            'currentStreak' => $this->currentStreak($attempts),
            'longestStreak' => $this->longestStreak($attempts),
            'attempts' => $attempts->count(),
        ];
    }

    /**
     * @param Collection<int, QuizAttempt> $attempts
     */
    private function currentStreak(Collection $attempts): int
    {
        $days = $this->attemptDays($attempts)->flip();

        if ($days->isEmpty()) {
            return 0;
        }

        $expected = CarbonImmutable::today();

        if (! $days->has($expected->toDateString())) {
            $expected = $expected->subDay();
        }

        $streak = 0;

        while ($days->has($expected->toDateString())) {
            $streak++;
            $expected = $expected->subDay();
        }

        return $streak;
    }

    /**
     * @param Collection<int, QuizAttempt> $attempts
     */
    private function longestStreak(Collection $attempts): int
    {
        $days = $this->attemptDays($attempts)->sort()->values();
        $longest = 0;
        $current = 0;
        $previous = null;

        foreach ($days as $day) {
            $date = CarbonImmutable::parse($day);

            if ($previous === null || $previous->addDay()->isSameDay($date)) {
                $current++;
            } else {
                $current = 1;
            }

            $longest = max($longest, $current);
            $previous = $date;
        }

        return $longest;
    }

    /**
     * @param Collection<int, QuizAttempt> $attempts
     * @return Collection<int, string>
     */
    private function attemptDays(Collection $attempts): Collection
    {
        return $attempts
            ->map(fn (QuizAttempt $attempt): ?string => $attempt->submitted_at?->toDateString())
            ->filter()
            ->unique()
            ->sortDesc()
            ->values();
    }
}
