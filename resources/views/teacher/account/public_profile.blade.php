@extends('layouts.teacher')


@section('content-main')

    <div class="content container-fluid">
        <div class="row justify-content-lg-center" style="max-width: 100%">
            <div class="col-lg-10">
                <!-- Profile Cover -->
                <div class="profile-cover">
                    <div class="profile-cover-img-wrapper">
                        <img class="profile-cover-img" src="assets/img/1920x400/img1.jpg" alt="Image Description">
                    </div>
                </div>

                <!-- Profile Header -->
                <div class="text-center mb-5">
                    <!-- Avatar -->
                    <div class="avatar avatar-xxl avatar-circle avatar-soft-primary profile-cover-avatar">
                        @if(isset($user->photo) && $user->photo)
                            <img id="editAvatarImgModal" class="avatar-img"
                                 src="{{ asset('storage/' . $user->photo) }}"
                                 alt="Фото профиля пользователя {{ $user->name }}">
                        @else
                            <span class="avatar-initials">{{ mb_substr($user->name, 0, 1) }}</span>

                        @endif                        <span class="avatar-status avatar-status-success"></span>
                    </div>
                    <!-- End Avatar -->

                    <h1 class="page-header-title">{{$user->name}}</h1>

                    <!-- List -->
                    <ul class="list-inline list-px-2">
                        <li class="list-inline-item">
                            <i class="bi-person-badge me-1"></i>
                            <span>Учитель</span>
                        </li>
                    </ul>
                    <!-- End List -->
                </div>
                <!-- End Profile Header -->

                <!-- Nav -->
                <div class="js-nav-scroller hs-nav-scroller-horizontal mb-5">
            <span class="hs-nav-scroller-arrow-prev" style="display: none;">
              <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                <i class="bi-chevron-left"></i>
              </a>
            </span>

                    <span class="hs-nav-scroller-arrow-next" style="display: none;">
              <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                <i class="bi-chevron-right"></i>
              </a>
            </span>

                    <ul class="nav nav-tabs align-items-center">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{route('profile.edit',['id'=>$user->id])}}">Профиль</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " href="{{route('profile.courses',['id'=>$user->id])}}">Курсы</a>
                        </li>


                    </ul>
                </div>
                <!-- End Nav -->

                <div class="row">
                    <!-- Биография -->
                    <div class="col-lg-12">
                        <div class="card">
                            <!-- Header -->
                            <div class="card-header card-header-content-between">
                                <h4 class="card-header-title">Биография</h4>


                            </div>
                            <!-- End Header -->

                            <!-- Body -->
                            <div class="card-body">
                                <!-- Блок биографии -->
                                <div id="bioText" class="bio-text">
                                    <p>{{ $user->bio ?? 'Биография не указана.' }}</p> <!-- Исправлено: boi → bio -->
                                </div>

                                <!-- Кнопка для переключения видимости текста -->
                                <a href="javascript:void(0)" id="toggleBio" class="link link-collapse d-none">Посмотреть больше</a>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const bioText = document.getElementById('bioText');
                                        const toggleButton = document.getElementById('toggleBio');

                                        // Проверяем, слишком ли длинный текст
                                        if (bioText.scrollHeight > 120) { // Если текст выше 120px — обрезаем
                                            bioText.style.maxHeight = '120px';
                                            bioText.style.overflow = 'hidden';
                                            bioText.style.position = 'relative';

                                            // Добавляем эффект "затемнения" внизу
                                            bioText.insertAdjacentHTML('beforeend', `
                                <div style="
                                    position: absolute;
                                    bottom: 0;
                                    left: 0;
                                    width: 100%;
                                    height: 30px;
                                    background: linear-gradient(to top, white, transparent);
                                    pointer-events: none;
                                "></div>
                            `);

                                            toggleButton.classList.remove('d-none'); // Показываем кнопку
                                        }

                                        toggleButton.addEventListener('click', function() {
                                            if (bioText.style.maxHeight === '120px' || bioText.style.maxHeight === '') {
                                                bioText.style.maxHeight = 'none';
                                                toggleButton.textContent = 'Посмотреть меньше';
                                            } else {
                                                bioText.style.maxHeight = '120px';
                                                toggleButton.textContent = 'Посмотреть больше';
                                            }
                                        });
                                    });
                                </script>
                            </div>
                            <!-- End Body -->
                        </div>
                    </div>

                    <!-- Лента активности -->
                    <div class="col-lg-12 mt-4">
                        <div class="card">
                            <!-- Header -->
                            <div class="card-header card-header-content-between">
                                <h4 class="card-header-title">Лента активности</h4>


                            </div>
                            <!-- End Header -->

                            <!-- Body -->
                            <div class="card-body" style="max-height: 280px; overflow-y: auto;">
                                <div class="chartjs-matrix-custom mb-3" style="min-width: 100%;">
                                    <canvas class="js-chart-matrix" style="min-height: 150px;"
                                            data-hs-chartjs-options='{
                            "options": {
                                "matrixBackgroundColord": {
                                    "color": "#377dff",
                                    "accent": 50,
                                    "additionToValue": 2
                                },
                                "matrixLegend": {
                                    "container": "#matrixLegend"
                                }
                            }
                        }'>
                                    </canvas>
                                </div>
                                <ul id="matrixLegend" class="mb-0"></ul>
                            </div>
                            <!-- End Body -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>

@endsection

@section('script')
    <script>
        function view_profile(user_g){
            console.log(user_g);

            var data = [];
            var start = moment().subtract(200, 'days').startOf('day');
            var end = moment().add(164, 'days').startOf('day'); // 30 дней в будущем

            var dt = start.clone();  // копия, чтобы не мутировать start

            while(dt <= end) {
                let found = user_g.action.find(a => a.date === dt.format('YYYY-MM-DD'));

                data.push({
                    x: dt.format('YYYY-MM-DD'),        // для оси X
                    y: dt.format('e'),                 // ISO день недели
                    d: dt.format('YYYY-MM-DD'),        // для tooltip
                    v: found ? (found.minutes / 60)*5 : 0 // часы (из минут)
                });

                dt = dt.add(1, 'day');
            }
            console.log(data);
            HSCore.components.HSChartMatrixJS.init(document.querySelector('.js-chart-matrix'), {
                data: {
                    datasets: [{
                        label: 'Commits',
                        data: data,
                        width(c) {
                            const a = c.chart.chartArea || {};
                            return (a.right - a.left) / 70;
                        },
                        height(c) {
                            const a = c.chart.chartArea || {};
                            return (a.bottom - a.top) / 7;
                        }
                    }]
                },
                options: {
                    aspectRatio: 5,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                title: function() { return '';},
                                label: function(item) {
                                    var v = item.dataset.data[item.dataIndex]; // исправлено здесь

                                    if (v.v.toFixed() > 0) {
                                        return '<span class="fw-semibold">' + v.v.toFixed()/5 + ' hours</span> on ' + v.d;
                                    }  else {
                                        return '<span class="fw-semibold">No time</span> on ' + v.d;
                                    }
                                }

                            }
                        },
                    },
                    scales: {
                        y: {
                            type: 'time',

                            offset: true,
                            time: {
                                unit: 'day',
                                round: 'day',
                                isoWeekday: 1,
                                parser: 'i',
                                displayFormats: {
                                    day: 'iiiiii'
                                }
                            },
                            reverse: true,
                            ticks: {
                                font: {
                                    size: 12,
                                },
                                maxTicksLimit: 5,
                                color: "rgba(22, 52, 90, 0.5)",
                                maxRotation: 0,
                                autoSkip: true
                            },
                            grid: {
                                display: false,
                                drawBorder: false,
                                tickLength: 0
                            }
                        },
                        x: {
                            type: 'time',
                            position: 'bottom',
                            offset: true,
                            time: {
                                unit: 'week',
                                round: 'week',
                                isoWeekday: 1,
                                displayFormats: {
                                    week: 'MMM dd'
                                }
                            },
                            ticks: {
                                font: {
                                    size: 12,
                                },
                                maxTicksLimit: 5,
                                color: "rgba(22, 52, 90, 0.5)",
                                maxRotation: 0,
                                autoSkip: true
                            },
                            grid: {
                                display: false,
                                drawBorder: false,
                                tickLength: 0,
                            }
                        }
                    }
                }
            })

        }
    </script>
@endsection
