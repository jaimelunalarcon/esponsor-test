<!DOCTYPE html>
<html lang="es">
<head>
    @vite('resources/css/public.css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/favicon.png">
    <title>{{ $site->public_name }}</title>
    <meta name="description" content="{{ $site->bio ?? 'Perfil público' }}">
    <meta property="og:title" content="{{ $site->public_name }}">
    <meta property="og:description" content="{{ $site->bio ?? 'Perfil público' }}">
    <meta property="og:image" content="{{ $site->avatar_url }}">
    <meta name="twitter:card" content="summary_large_image">
</head>
<body>
    @php
        $initials = collect(explode(' ', $site->public_name))
            ->filter()
            ->take(2)
            ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
            ->implode('');

        $getContrastColor = function ($bgColor) {
            if (!$bgColor || !is_string($bgColor)) {
                return '#0f172a';
            }

            $hex = ltrim($bgColor, '#');

            if (strlen($hex) !== 6) {
                return '#0f172a';
            }

            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));

            $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;

            return $brightness > 150 ? '#0f172a' : '#ffffff';
        };

        $socialBlock = collect($blocks)->first(function ($block) {
            return ($block['type'] ?? null) === 'social' && (($block['enabled'] ?? true) !== false);
        });

        $contentBlocks = collect($blocks)->filter(function ($block) {
            return ($block['type'] ?? null) !== 'social';
        })->values();
    @endphp

    <main class="page lg:m-0 lg:p-0">
        <section class="profile-card">
            <div class="banner-profile"
                @if($site->banner_url)
                    style="
                        background-image: url('{{ $site->banner_url }}');
                        background-size: cover;
                        background-position: center;
                        background-repeat: no-repeat;
                    "
                @endif
            ></div>

            @if($site->avatar_url)
                <img
                    src="{{ $site->avatar_url }}"
                    alt="{{ $site->public_name }}"
                    class="avatar"
                    loading="eager"
                >
            @else
                <div class="avatar-fallback">{{ $initials ?: 'U' }}</div>
            @endif

            <h1 class="name">{{ $site->public_name }}</h1>

            @if($socialBlock)
                <div style="display:flex; justify-content:center; gap:16px; margin-top:14px; margin-bottom:10px;">
                    @if(!empty($socialBlock['props']['instagram']))
                        <a href="{{ $socialBlock['props']['instagram'] }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram" style="color:#475569; transition:all .2s ease;">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true">
                                <path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2Zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5a4.25 4.25 0 0 0 4.25-4.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5Zm8.75 2a1 1 0 1 1 0 2 1 1 0 0 1 0-2ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.5A3.5 3.5 0 1 0 12 15.5 3.5 3.5 0 0 0 12 8.5Z"/>
                            </svg>
                        </a>
                    @endif

                    @if(!empty($socialBlock['props']['tiktok']))
                        <a href="{{ $socialBlock['props']['tiktok'] }}" target="_blank" rel="noopener noreferrer" aria-label="TikTok" style="color:#475569; transition:all .2s ease;">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true">
                                <path d="M14 3c.4 1.9 1.6 3.4 3.5 4.1.9.3 1.8.4 2.5.4V10c-1 0-2-.2-2.9-.6-.5-.2-1-.5-1.6-.9v6.2a5.7 5.7 0 1 1-5.7-5.7c.3 0 .7 0 1 .1v2.4a3.2 3.2 0 1 0 2.2 3v-11H14Z"/>
                            </svg>
                        </a>
                    @endif

                    @if(!empty($socialBlock['props']['x']))
                        <a href="{{ $socialBlock['props']['x'] }}" target="_blank" rel="noopener noreferrer" aria-label="X" style="color:#475569; transition:all .2s ease;">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true">
                                <path d="M18.9 2H22l-6.8 7.8L23 22h-6.1l-4.8-6.3L6.6 22H3.5l7.3-8.4L1 2h6.3l4.3 5.8L18.9 2Zm-1.1 18h1.7L6.4 3.9H4.6L17.8 20Z"/>
                            </svg>
                        </a>
                    @endif

                    @if(!empty($socialBlock['props']['facebook']))
                        <a href="{{ $socialBlock['props']['facebook'] }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook" style="color:#475569; transition:all .2s ease;">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true">
                                <path d="M13.5 22v-8.2h2.8l.4-3.2h-3.2V8.6c0-.9.2-1.5 1.5-1.5h1.8V4.2c-.3 0-1.3-.1-2.5-.1-2.5 0-4.1 1.5-4.1 4.4v2.1H7.5v3.2H10V22h3.5Z"/>
                            </svg>
                        </a>
                    @endif
                </div>
            @endif

            @if($site->bio)
                <p class="bio">{{ $site->bio }}</p>
            @endif
        </section>

        <div class="container">
            <section class="blocks">
                @forelse ($contentBlocks as $index => $block)
                    @if (($block['type'] ?? null) === 'text')
                        @php
                            $backgroundColor = $block['props']['backgroundColor'] ?? '#ffffff';
                            $textColor = $getContrastColor($backgroundColor);
                        @endphp

                        <article
                            class="block-card block-text-body block-animate block-links"
                            style="
                                --delay: {{ $index * 120 }}ms;
                                background-color: {{ $backgroundColor }};
                                color: {{ $textColor }};
                            "
                        >
                            <div class="block-body">
                                @if(!empty($block['props']['title']))
                                    <h2
                                        class="block-title"
                                        style="color: {{ $textColor }};"
                                    >
                                        {{ $block['props']['title'] }}
                                    </h2>
                                @endif

                                @if(!empty($block['props']['content']))
                                    <p
                                        class="block-text"
                                        style="color: {{ $textColor }};"
                                    >
                                        {{ $block['props']['content'] }}
                                    </p>
                                @endif
                            </div>
                        </article>
                    @endif

                    @if (($block['type'] ?? null) === 'image')
                        <article
                            class="block-card block-animate block-links"
                            style="--delay: {{ $index * 90 }}ms;"
                        >
                            @if(!empty($block['props']['image_url']))
                                <img
                                    src="{{ $block['props']['image_url'] }}"
                                    alt="{{ $block['props']['alt'] ?? 'Imagen' }}"
                                    class="block-image"
                                    loading="lazy"
                                >
                            @endif
                        </article>
                    @endif

                    @if (($block['type'] ?? null) === 'links')
                        <article
                            class="block-card block-animate block-links"
                            style="--delay: {{ $index * 120 }}ms;"
                        >
                            <div class="block-body">
                                <div class="links-list">
                                    @foreach (($block['props']['links'] ?? []) as $link)
                                        @if(!empty($link['url']))
                                            @php
                                                $bg = $link['backgroundColor'] ?? '#0f172a';
                                                $text = $getContrastColor($bg);
                                            @endphp

                                            <a
                                                href="{{ $link['url'] }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="link-button"
                                                style="
                                                    background-color: {{ $bg }};
                                                    color: {{ $text }};
                                                "
                                            >
                                                {{ $link['label'] ?? 'Abrir enlace' }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </article>
                    @endif

                    @if (($block['type'] ?? null) === 'video')
                        @php
                            $videoUrl = $block['props']['embed_url'] ?? '';

                            if (str_contains($videoUrl, 'youtu.be/')) {
                                $videoId = explode('youtu.be/', $videoUrl)[1] ?? '';
                                $videoId = explode('?', $videoId)[0] ?? '';
                                $videoUrl = $videoId ? 'https://www.youtube.com/embed/' . $videoId : '';
                            }

                            if (str_contains($videoUrl, 'youtube.com/watch?v=')) {
                                $videoId = explode('v=', $videoUrl)[1] ?? '';
                                $videoId = explode('&', $videoId)[0] ?? '';
                                $videoUrl = $videoId ? 'https://www.youtube.com/embed/' . $videoId : '';
                            }
                        @endphp

                        @if(!empty($videoUrl))
                            <article
                                class="block-card block-animate"
                                style="--delay: {{ $index * 120 }}ms;"
                            >
                                <div class="video-wrapper">
                                    <iframe
                                        src="{{ $videoUrl }}"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen
                                    ></iframe>
                                </div>
                            </article>
                        @endif
                    @endif
                @empty
                    <article class="block-card">
                        <div class="block-body">
                            <p class="block-text">Aún no hay contenido publicado.</p>
                        </div>
                    </article>
                @endforelse
            </section>

            <div class="footer-note">
                <a
                    href="#"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="footer-powered"
                >
                    <span>Powered by</span>

                    <img
                        src="/images/esponsor-logo.svg"
                        alt="Esponsor"
                    >
                </a>
            </div>
        </div>
    </main>

    <script>
        const gradients = [
          "linear-gradient(65deg, #ebf4f5, #b5c6e0)",
          "linear-gradient(65deg, #f6d5f7, #fbe9d7)",
          "linear-gradient(65deg, #e9b7ce, #d3f3f1)",
          "linear-gradient(65deg, #eed991, #ccf7f4)",
          "linear-gradient(65deg, #6d90b9, #bbc7dc)"
        ]

        document.addEventListener("DOMContentLoaded", () => {
          const banner = document.querySelector(".banner-profile")
          if (!banner) return

          const hasImage = banner.style.backgroundImage && banner.style.backgroundImage !== "none"

          if (!hasImage) {
            const random = gradients[Math.floor(Math.random() * gradients.length)]
            banner.style.background = random
          }
        })
    </script>
</body>
</html>