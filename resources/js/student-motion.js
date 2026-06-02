import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const initStudentMotion = () => {
    const hasMotionTargets = document.querySelector('[data-gsap-hero], [data-gsap-reveal], [data-gsap-quiz-card], [data-gsap-score]');

    if (!hasMotionTargets) {
        return;
    }

    const mm = gsap.matchMedia();

    mm.add(
        {
            reduceMotion: '(prefers-reduced-motion: reduce)',
            fullMotion: '(prefers-reduced-motion: no-preference)',
        },
        (context) => {
            if (context.conditions.reduceMotion) {
                gsap.set('[data-gsap-hero], [data-gsap-reveal], [data-gsap-quiz-card], [data-gsap-score]', {
                    clearProps: 'all',
                });

                return;
            }

            const hero = document.querySelector('[data-gsap-hero]');

            if (hero) {
                gsap.from(hero, {
                    autoAlpha: 0,
                    y: 18,
                    scale: 0.985,
                    duration: 0.75,
                    ease: 'power3.out',
                });
            }

            const revealTargets = gsap.utils.toArray('[data-gsap-reveal], [data-gsap-quiz-card]');

            if (revealTargets.length > 0) {
                ScrollTrigger.batch(revealTargets, {
                    start: 'top 86%',
                    once: true,
                    onEnter: (elements) => {
                        gsap.fromTo(
                            elements,
                            { autoAlpha: 0, y: 26, scale: 0.985 },
                            {
                                autoAlpha: 1,
                                y: 0,
                                scale: 1,
                                duration: 0.7,
                                ease: 'power3.out',
                                stagger: 0.08,
                                overwrite: true,
                            },
                        );
                    },
                });
            }

            const mediaImages = gsap.utils.toArray('.eq-media-frame img');

            if (mediaImages.length > 0) {
                gsap.fromTo(
                    mediaImages,
                    { scale: 1.06 },
                    {
                        scale: 1,
                        duration: 1.2,
                        ease: 'power2.out',
                        scrollTrigger: {
                            trigger: mediaImages[0].closest('.eq-media-frame'),
                            start: 'top 85%',
                            toggleActions: 'play none none reverse',
                        },
                    },
                );
            }

            const scoreTargets = gsap.utils.toArray('[data-gsap-score]');

            scoreTargets.forEach((target) => {
                const finalValue = Number.parseInt(target.textContent, 10);

                if (Number.isNaN(finalValue)) {
                    return;
                }

                const counter = { value: 0 };
                gsap.to(counter, {
                    value: finalValue,
                    duration: 0.9,
                    ease: 'power3.out',
                    onUpdate: () => {
                        target.textContent = Math.round(counter.value).toString();
                    },
                });
            });
        },
    );
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initStudentMotion, { once: true });
} else {
    initStudentMotion();
}
