@extends('layouts.app')
@section('content-main')

    <script src="https://unpkg.com/lucide/dist/lucide.min.js"></script>

    <style>
        /* общий контейнер */
        .catalog-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* поиск */
        .search-box {
            max-width: 900px;
            margin: 0 auto 30px;
        }

        /* фильтры */
        .filter-chip {
            cursor: pointer;
            border-radius: 999px;
            padding: 6px 14px;
            border: 1px solid #e9e9e9;
            background: #f9f9f9;
            font-size: .9rem;
            margin-right: 8px;
        }
        .filter-chip:hover {
            background: #f1f1f1;
        }

        /* карточки курсов */
        .course-card {
            border: 1px solid #e6e6e6;
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
            transition: transform .12s ease, box-shadow .12s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0,0,0,.08);
        }
        .course-thumb {
            height: 140px;
            object-fit: cover;
            width: 100%;
        }
        .course-body {
            padding: 16px;
            position: relative;
            flex: 1;
        }
        .course-logo {
            width: 46px; height: 46px;
            border-radius: 10px;
            background: #fff;
            border: 1px solid #ddd;
            overflow: hidden;
            position: absolute;
            top: -23px; left: 16px;
            display: flex; align-items: center; justify-content: center;
        }
        .course-logo img { width: 100%; height: 100%; object-fit: cover; }
        .course-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 6px;
        }
        .course-meta {
            font-size: .85rem;
            color: #6b6b6b;
        }
    </style>

    <div class="catalog-container py-4">

        {{-- Поиск --}}
        <form method="GET" action="#" class="d-flex search-box">
            <input class="form-control me-2" placeholder="Поиск курсов...">
            <button class="btn btn-primary" type="submit">
                <i data-lucide="search"></i>
            </button>
        </form>

        {{-- Фильтры --}}
        <div class="mb-4 d-flex flex-wrap gap-2">
            <span class="filter-chip">Все</span>
            <span class="filter-chip">Программирование</span>
            <span class="filter-chip">Web</span>
            <span class="filter-chip">Data Science</span>
            <span class="filter-chip">Языки</span>
            <span class="filter-chip">Дизайн</span>
            <span class="filter-chip">Бизнес</span>
        </div>

        {{-- Сетка карточек --}}
        <div class="row g-4">

            {{-- курс 1 --}}
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="course-card">
                    <img src="https://picsum.photos/400/200?1" class="course-thumb" alt="cover">
                    <div class="course-body">
                        <div class="course-logo">
                            <img src="https://img.icons8.com/color/48/python.png" alt="logo">
                        </div>
                        <div class="mt-4">
                            <div class="course-title">Курс по Python</div>
                            <div class="course-meta">Основы программирования на Python</div>
                            <div class="small text-muted mt-2">Автор: Иванов</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- курс 2 --}}
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="course-card">
                    <img src="https://picsum.photos/400/200?2" class="course-thumb" alt="cover">
                    <div class="course-body">
                        <div class="course-logo">
                            <img src="https://img.icons8.com/color/48/html-5.png" alt="logo">
                        </div>
                        <div class="mt-4">
                            <div class="course-title">Web-разработка</div>
                            <div class="course-meta">HTML, CSS и основы JavaScript</div>
                            <div class="small text-muted mt-2">Автор: Петров</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- курс 3 --}}
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="course-card">
                    <img src="https://picsum.photos/400/200?3" class="course-thumb" alt="cover">
                    <div class="course-body">
                        <div class="course-logo">
                            <img src="https://img.icons8.com/color/48/database.png" alt="logo">
                        </div>
                        <div class="mt-4">
                            <div class="course-title">SQL для начинающих</div>
                            <div class="course-meta">Работа с базами данных</div>
                            <div class="small text-muted mt-2">Автор: Сидоров</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- курс 4 --}}
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="course-card">
                    <img src="https://picsum.photos/400/200?4" class="course-thumb" alt="cover">
                    <div class="course-body">
                        <div class="course-logo">
                            <img src="https://img.icons8.com/color/48/artificial-intelligence.png" alt="logo">
                        </div>
                        <div class="mt-4">
                            <div class="course-title">Machine Learning</div>
                            <div class="course-meta">Основы машинного обучения</div>
                            <div class="small text-muted mt-2">Автор: Смирнов</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Пагинация --}}
        <div class="mt-4 d-flex justify-content-center">
            <nav>
                <ul class="pagination">
                    <li class="page-item disabled"><span class="page-link">«</span></li>
                    <li class="page-item active"><span class="page-link">1</span></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul>
            </nav>
        </div>
    </div>
    {{-- Авторы --}}
    <div class="mt-5">
        <h5 class="mb-3">Авторы курсов</h5>
        <div class="d-flex align-items-center">

            {{-- Стрелка влево --}}
            <button class="btn btn-light me-2" id="authorsPrev" style="border-radius:50%; width:38px; height:38px;">
                <i data-lucide="chevron-left"></i>
            </button>

            {{-- Лента авторов --}}
            <div class="flex-grow-1 overflow-hidden">
                <div class="d-flex gap-3 overflow-auto pb-2" id="authorsSlider" style="scroll-behavior: smooth;">

                    {{-- Автор 1 --}}
                    <div class="text-center" style="min-width:90px;">
                        <div class="author-avatar mx-auto mb-1">
                            <img src="https://i.pravatar.cc/80?img=1" class="rounded-circle border" width="60" height="60" alt="Иванов">
                        </div>
                        <small>Иванов</small>
                    </div>

                    {{-- Автор 2 --}}
                    <div class="text-center" style="min-width:90px;">
                        <div class="author-avatar mx-auto mb-1">
                            <img src="https://i.pravatar.cc/80?img=2" class="rounded-circle border" width="60" height="60" alt="Петров">
                        </div>
                        <small>Петров</small>
                    </div>

                    {{-- Автор 3 --}}
                    <div class="text-center" style="min-width:90px;">
                        <div class="author-avatar mx-auto mb-1">
                            <img src="https://i.pravatar.cc/80?img=3" class="rounded-circle border" width="60" height="60" alt="Сидоров">
                        </div>
                        <small>Сидоров</small>
                    </div>

                    {{-- Автор 4 --}}
                    <div class="text-center" style="min-width:90px;">
                        <div class="author-avatar mx-auto mb-1">
                            <img src="https://i.pravatar.cc/80?img=4" class="rounded-circle border" width="60" height="60" alt="Смирнов">
                        </div>
                        <small>Смирнов</small>
                    </div>

                    {{-- Автор 5 --}}
                    <div class="text-center" style="min-width:90px;">
                        <div class="author-avatar mx-auto mb-1">
                            <img src="https://i.pravatar.cc/80?img=5" class="rounded-circle border" width="60" height="60" alt="Кузнецов">
                        </div>
                        <small>Кузнецов</small>
                    </div>

                </div>
            </div>

            {{-- Стрелка вправо --}}
            <button class="btn btn-light ms-2" id="authorsNext" style="border-radius:50%; width:38px; height:38px;">
                <i data-lucide="chevron-right"></i>
            </button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function(){
            if(window.lucide) lucide.replace();

            const slider = document.getElementById('authorsSlider');
            document.getElementById('authorsPrev').addEventListener('click', () => {
                slider.scrollBy({ left: -150, behavior: 'smooth' });
            });
            document.getElementById('authorsNext').addEventListener('click', () => {
                slider.scrollBy({ left: 150, behavior: 'smooth' });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function(){ if(window.lucide) lucide.replace() })
    </script>
@endsection
