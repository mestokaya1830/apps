<!DOCTYPE html>

<html lang="tr">
<meta charset="utf-8">
<title>gbbenerji</title>
<meta name="description" content="Analytics Dashboard">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="msapplication-tap-highlight" content="no">
<link id="vendorsbundle" rel="stylesheet" media="screen, print" href="{{ asset('css/vendors.bundle.css') }}">
<link id="appbundle" rel="stylesheet" media="screen, print" href="{{ asset('css/app.bundle.css') }}">
<link id="mytheme" rel="stylesheet" media="screen, print" href="#">
<link id="myskin" rel="stylesheet" media="screen, print" href="{{ asset('css/skins/skin-master.css') }}">
<link rel="icon" type="image/png" sizes="32x32" href="/img/favicon.png">
<link rel="stylesheet" media="screen, print" href="{{ asset('css/miscellaneous/reactions/reactions.css') }}">
<link rel="stylesheet" media="screen, print"href="{{ asset('css/miscellaneous/fullcalendar/fullcalendar.bundle.css') }}">
<link rel="stylesheet" media="screen, print" href="{{ asset('css/miscellaneous/jqvmap/jqvmap.bundle.css') }}">
<link rel="stylesheet" media="screen, print" href="{{ asset('css/datagrid/datatables/datatables.bundle.css') }}">
<style>
    .custom-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
    }

</style>
</head>

<body class="mod-bg-1 mod-nav-link ">
    <div class="page-wrapper">
        <div class="page-inner">
            <aside class="page-sidebar">
                <a href="{{ route('admin.dashboard') }}">
                    <div class="page-logo">
                        <img src="{{ asset('img/favicon.png') }}" aria-roledescription="logo">
                        <span class="page-logo-text mr-1">
                            @if (Auth::check())
                                {{ Auth::user()->name }}
                            @endif
                        </span>
                        <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
                    </div>
                </a>
                <nav id="js-primary-nav" class="primary-nav" role="navigation">
                    <ul id="js-nav-menu" class="nav-menu">
                        <li class="active open">
                            <a href="#" title="Application Intel" data-filter-tags="application intel">
                                <span class="nav-link-text" data-i18n="nav.application_intel">
                                    <a href="{{ route('users.index') }}">Kullanıcılar</a>
                                </span>
                            </a>
                        </li>
                        <li class="active open">
                            <a href="#" title="Application Intel" data-filter-tags="application intel">
                                <span class="nav-link-text" data-i18n="nav.application_intel">
                                    <a href="{{ route('quiz.index') }}">Sorular</a>
                                </span>
                            </a>
                        </li>
                        <li class="active open">
                            <a href="#" title="Application Intel" data-filter-tags="application intel">
                                <span class="nav-link-text" data-i18n="nav.application_intel">
                                    <a href="{{ route('joiners.index') }}">Katılımcılar</a>
                                </span>
                            </a>
                        </li>

                    </ul>
                    <div class="filter-message js-filter-message bg-success-600"></div>
                </nav>
            </aside>
            <div class="page-content-wrapper">
                <header class="page-header" role="banner">
                    <div class="page-logo">
                        <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative"
                            data-toggle="modal" data-target="#modal-shortcut">


                            <span
                                class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
                            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
                        </a>
                    </div>
                    <div class="hidden-md-down dropdown-icon-menu position-relative">
                        <a href="#" class="header-btn btn js-waves-off" data-action="toggle"
                            data-class="nav-function-hidden" title="Hide Navigation">
                            <i class="ni ni-menu"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="#" class="btn js-waves-off" data-action="toggle"
                                    data-class="nav-function-minify" title="Minify Navigation">
                                    <i class="ni ni-minify-nav"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn js-waves-off" data-action="toggle"
                                    data-class="nav-function-fixed" title="Lock Navigation">
                                    <i class="ni ni-lock-nav"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="hidden-lg-up">
                        <a href="#" class="header-btn btn press-scale-down" data-action="toggle"
                            data-class="mobile-nav-on">
                            <i class="ni ni-menu"></i>
                        </a>
                    </div>
                    <div class="ml-auto d-flex">
                        <div class="hidden-sm-up">
                            <a href="#" class="header-icon" data-action="toggle" data-class="mobile-search-on"
                                data-focus="search-field" title="Search">
                                <i class="fal fa-search"></i>
                            </a>
                        </div>
                        <div>

                            <a href="#" data-toggle="dropdown" title="gbbenerji.com.tr"
                                class="header-icon d-flex align-items-center justify-content-center ml-2">
                                <img src="{{ asset('img/admin.png') }}" class="profile-image rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-animated dropdown-lg">
                                <div class="dropdown-header bg-trans-gradient d-flex flex-row py-4 rounded-top">
                                    <div class="d-flex flex-row align-items-center mt-1 mb-1 color-white">
                                        <div class="info-card-text">
                                            <a class="fs-lg text-truncate text-truncate-lg"
                                                style="color:#fff;">{{ Auth::user()->name }}</a>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" class="dropdown-item" data-action="app-print">
                                    <span data-i18n="drpdwn.print">Yazdır</span>
                                    <i class="float-right text-muted fw-n">Ctrl + P</i>
                                </a>

                                <div class="dropdown-divider m-0"></div>
                                <span data-i18n="drpdwn.page-logout">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();"
                                        class="dropdown-item fw-500 pt-3 pb-3">Çıkış</a>
                                </span>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </header>
                <main id="js-page-content" role="main" class="page-content">

                    <div class="subheader">
                        <h1 class="subheader-title">
                            <i class='subheader-icon fal fa-chart-area'></i><span class='fw-300'>Admin Paneli</span>
                        </h1>
                    </div>
                    @if ($errors->any)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger m-1" role="alert">{{ $error }}</div>
                        @endforeach
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success m-1" role="alert"><i
                                class="fa fa-check m-1"></i>{{ session('success') }}</div>
                    @endif
                    <div class="row">@yield('content')</div>
                </main>
                <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div>
                <!-- END Page Content -->
                <footer class="page-footer" role="contentinfo">
                    <div class="d-flex align-items-center flex-1 text-muted">
                        <a href='https://gaziantepbilisim.com.tr' class='text-primary fw-500' title='gbbenerji'
                            target='_blank'> <span
                                class="hidden-md-down fw-700">gaziantepbilişim.com.tr&nbsp;</a></span>
                    </div>
                </footer>

                <p id="js-color-profile" class="d-none">
                    <span class="color-primary-50"></span>
                    <span class="color-primary-100"></span>
                    <span class="color-primary-200"></span>
                    <span class="color-primary-300"></span>
                    <span class="color-primary-400"></span>
                    <span class="color-primary-500"></span>
                    <span class="color-primary-600"></span>
                    <span class="color-primary-700"></span>
                    <span class="color-primary-800"></span>
                    <span class="color-primary-900"></span>
                    <span class="color-info-50"></span>
                    <span class="color-info-100"></span>
                    <span class="color-info-200"></span>
                    <span class="color-info-300"></span>
                    <span class="color-info-400"></span>
                    <span class="color-info-500"></span>
                    <span class="color-info-600"></span>
                    <span class="color-info-700"></span>
                    <span class="color-info-800"></span>
                    <span class="color-info-900"></span>
                    <span class="color-danger-50"></span>
                    <span class="color-danger-100"></span>
                    <span class="color-danger-200"></span>
                    <span class="color-danger-300"></span>
                    <span class="color-danger-400"></span>
                    <span class="color-danger-500"></span>
                    <span class="color-danger-600"></span>
                    <span class="color-danger-700"></span>
                    <span class="color-danger-800"></span>
                    <span class="color-danger-900"></span>
                    <span class="color-warning-50"></span>
                    <span class="color-warning-100"></span>
                    <span class="color-warning-200"></span>
                    <span class="color-warning-300"></span>
                    <span class="color-warning-400"></span>
                    <span class="color-warning-500"></span>
                    <span class="color-warning-600"></span>
                    <span class="color-warning-700"></span>
                    <span class="color-warning-800"></span>
                    <span class="color-warning-900"></span>
                    <span class="color-success-50"></span>
                    <span class="color-success-100"></span>
                    <span class="color-success-200"></span>
                    <span class="color-success-300"></span>
                    <span class="color-success-400"></span>
                    <span class="color-success-500"></span>
                    <span class="color-success-600"></span>
                    <span class="color-success-700"></span>
                    <span class="color-success-800"></span>
                    <span class="color-success-900"></span>
                    <span class="color-fusion-50"></span>
                    <span class="color-fusion-100"></span>
                    <span class="color-fusion-200"></span>
                    <span class="color-fusion-300"></span>
                    <span class="color-fusion-400"></span>
                    <span class="color-fusion-500"></span>
                    <span class="color-fusion-600"></span>
                    <span class="color-fusion-700"></span>
                    <span class="color-fusion-800"></span>
                    <span class="color-fusion-900"></span>
                </p>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/vendors.bundle.js') }}"></script>
    <script src="{{ asset('js/app.bundle.js') }}"></script>
    <script type="text/javascript">
        $('#js-page-content').smartPanel();
    </script>

    <script src="{{ asset('js/dependency/moment/moment.js') }}"></script>
    <script src="{{ asset('js/miscellaneous/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('js/statistics/sparkline/sparkline.bundle.js') }}"></script>
    <script src="{{ asset('js/statistics/easypiechart/easypiechart.bundle.js') }}"></script>
    <script src="{{ asset('js/statistics/flot/flot.bundle.js') }}"></script>
    <script src="{{ asset('js/datagrid/datatables/datatables.bundle.js') }} "></script>
    <script>
        'use strict';

        var classHolder = document.getElementsByTagName("BODY")[0],
            themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
            {},
            themeURL = themeSettings.themeURL || '',
            themeOptions = themeSettings.themeOptions || '';
        if (themeSettings.themeOptions) {
            classHolder.className = themeSettings.themeOptions;
            console.log("%c✔ Theme settings loaded", "color: #148f32");
        } else {
            console.log("%c✔ Heads up! Theme settings is empty or does not exist, loading default settings...",
                "color: #ed1c24");
        }
        if (themeSettings.themeURL && !document.getElementById('mytheme')) {
            var cssfile = document.createElement('link');
            cssfile.id = 'mytheme';
            cssfile.rel = 'stylesheet';
            cssfile.href = themeURL;
            document.getElementsByTagName('head')[0].appendChild(cssfile);

        } else if (themeSettings.themeURL && document.getElementById('mytheme')) {
            document.getElementById('mytheme').href = themeSettings.themeURL;
        }
        var saveSettings = function() {
            themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item) {
                return /^(nav|header|footer|mod|display)-/i.test(item);
            }).join(' ');
            if (document.getElementById('mytheme')) {
                themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
            };
            localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
        }
        var resetSettings = function() {
            localStorage.setItem("themeSettings", "");
        }
    </script>
    @yield('js')
    <script>
        $(document).ready(function() {

            var dataSetPie = [{
                    label: "Asia",
                    data: 4119630000,
                    color: color.primary._500
                },
                {
                    label: "Latin America",
                    data: 590950000,
                    color: color.info._500
                },
                {
                    label: "Africa",
                    data: 1012960000,
                    color: color.warning._500
                },
                {
                    label: "Oceania",
                    data: 95100000,
                    color: color.danger._500
                },
                {
                    label: "Europe",
                    data: 727080000,
                    color: color.success._500
                },
                {
                    label: "North America",
                    data: 344120000,
                    color: color.fusion._400
                }
            ];


            $.plot($("#flotPie"), dataSetPie, {
                series: {
                    pie: {
                        innerRadius: 0.5,
                        show: true,
                        radius: 1,
                        label: {
                            show: true,
                            radius: 2 / 3,
                            threshold: 0.1
                        }
                    }
                },
                legend: {
                    show: false
                }
            });


            $.plot('#flotBar1', [{
                    data: [
                        [1, 0],
                        [2, 0],
                        [3, 0],
                        [4, 1],
                        [5, 3],
                        [6, 3],
                        [7, 10],
                        [8, 11],
                        [9, 10],
                        [10, 9],
                        [11, 12],
                        [12, 8],
                        [13, 10],
                        [14, 6],
                        [15, 3]
                    ],
                    bars: {
                        show: true,
                        lineWidth: 0,
                        fillColor: color.fusion._50,
                        barWidth: .3,
                        order: 'left'
                    }
                },
                {
                    data: [
                        [1, 0],
                        [2, 0],
                        [3, 1],
                        [4, 2],
                        [5, 2],
                        [6, 5],
                        [7, 8],
                        [8, 12],
                        [9, 10],
                        [10, 11],
                        [11, 3]
                    ],
                    bars: {
                        show: true,
                        lineWidth: 0,
                        fillColor: color.success._500,
                        barWidth: .3,
                        align: 'right'
                    }
                }
            ], {
                grid: {
                    borderWidth: 0,
                },
                yaxis: {
                    min: 0,
                    max: 15,
                    tickColor: 'rgba(0,0,0,0.05)',
                    ticks: [
                        [0, ''],
                        [5, '$5000'],
                        [10, '$25000'],
                        [15, '$45000']
                    ],
                    font: {
                        color: '#444',
                        size: 10
                    }
                },
                xaxis: {
                    mode: 'categories',
                    tickColor: 'rgba(0,0,0,0.05)',
                    ticks: [
                        [0, '3am'],
                        [1, '4am'],
                        [2, '5am'],
                        [3, '6am'],
                        [4, '7am'],
                        [5, '8am'],
                        [6, '9am'],
                        [7, '10am'],
                        [8, '11am'],
                        [9, '12nn'],
                        [10, '1pm'],
                        [11, '2pm'],
                        [12, '3pm'],
                        [13, '4pm'],
                        [14, '5pm']
                    ],
                    font: {
                        color: '#999',
                        size: 9
                    }
                }
            });





            var data = [],
                totalPoints = 200;
            var getRandomData = function() {
                if (data.length > 0)
                    data = data.slice(1);

                while (data.length < totalPoints) {
                    var prev = data.length > 0 ? data[data.length - 1] : 50;
                    var y = prev + Math.random() * 10 - 5;
                    if (y < 0)
                        y = 0;
                    if (y > 100)
                        y = 100;
                    data.push(y);
                }


                var res = [];
                for (var i = 0; i < data.length; ++i)
                    res.push([i, data[i]])
                return res;
            }

            var updateInterval = 1500;
            $("#updating-chart").val(updateInterval).change(function() {

                var v = $(this).val();
                if (v && !isNaN(+v)) {
                    updateInterval = +v;
                    $(this).val("" + updateInterval);
                }

            });

            var options = {
                colors: [color.primary._700],
                series: {
                    lines: {
                        show: true,
                        lineWidth: 0.5,
                        fill: 0.9,
                        fillColor: {
                            colors: [{
                                    opacity: 0.6
                                },
                                {
                                    opacity: 0
                                }
                            ]
                        },
                    },

                    shadowSize: 0
                },
                grid: {
                    borderColor: 'rgba(0,0,0,0.05)',
                    borderWidth: 1,
                    labelMargin: 5
                },
                xaxis: {
                    color: '#F0F0F0',
                    tickColor: 'rgba(0,0,0,0.05)',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                },
                yaxis: {
                    min: 0,
                    max: 100,
                    color: '#F0F0F0',
                    tickColor: 'rgba(0,0,0,0.05)',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                }
            };
            var plot = $.plot($("#updating-chart"), [getRandomData()], options);

            $('input[type="checkbox"]#start_interval').click(function() {
                if ($(this).prop('checked')) {
                    $on = true;
                    updateInterval = 1500;
                    update();
                } else {
                    clearInterval(updateInterval);
                    $on = false;
                }
            });
            var update = function() {
                if ($on == true) {
                    plot.setData([getRandomData()]);
                    plot.draw();
                    setTimeout(update, updateInterval);

                } else {
                    clearInterval(updateInterval)
                }

            }




            var todayDate = moment().startOf('day');
            var YM = todayDate.format('YYYY-MM');
            var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
            var TODAY = todayDate.format('YYYY-MM-DD');
            var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');


            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['dayGrid', 'list', 'timeGrid', 'interaction', 'bootstrap'],
                themeSystem: 'bootstrap',
                timeZone: 'UTC',

                buttonText: {
                    today: 'today',
                    month: 'month',
                    week: 'week',
                    day: 'day',
                    list: 'list'
                },
                eventTimeFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    meridiem: 'short'
                },
                navLinks: true,
                header: {
                    left: 'title',
                    center: '',
                    right: 'today prev,next'
                },
                footer: {
                    left: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                    center: '',
                    right: ''
                },
                editable: true,
                eventLimit: true,
                events: [{
                        title: 'All Day Event',
                        start: YM + '-01',
                        description: 'This is a test description',
                        className: "border-warning bg-warning text-dark"
                    },
                    {
                        title: 'Reporting',
                        start: YM + '-14T13:30:00',
                        end: YM + '-14',
                        className: "bg-white border-primary text-primary"
                    },
                    {
                        title: 'Surgery oncall',
                        start: YM + '-02',
                        end: YM + '-03',
                        className: "bg-primary border-primary text-white"
                    },
                    {
                        title: 'NextGen Expo 2019 - Product Release',
                        start: YM + '-03',
                        end: YM + '-05',
                        className: "bg-info border-info text-white"
                    },
                    {
                        title: 'Dinner',
                        start: YM + '-12',
                        end: YM + '-10'
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: YM + '-09T16:00:00',
                        className: "bg-danger border-danger text-white"
                    },
                    {
                        id: 1000,
                        title: 'Repeating Event',
                        start: YM + '-16T16:00:00'
                    },
                    {
                        title: 'Conference',
                        start: YESTERDAY,
                        end: TOMORROW,
                        className: "bg-success border-success text-white"
                    },
                    {
                        title: 'Meeting',
                        start: TODAY + 'T10:30:00',
                        end: TODAY + 'T12:30:00',
                        className: "bg-primary text-white border-primary"
                    },
                    {
                        title: 'Lunch',
                        start: TODAY + 'T12:00:00',
                        className: "bg-info border-info"
                    },
                    {
                        title: 'Meeting',
                        start: TODAY + 'T14:30:00',
                        className: "bg-warning text-dark border-warning"
                    },
                    {
                        title: 'Happy Hour',
                        start: TODAY + 'T17:30:00',
                        className: "bg-success border-success text-white"
                    },
                    {
                        title: 'Dinner',
                        start: TODAY + 'T20:00:00',
                        className: "bg-danger border-danger text-white"
                    },
                    {
                        title: 'Birthday Party',
                        start: TOMORROW + 'T07:00:00',
                        className: "bg-primary text-white border-primary text-white"
                    },
                    {
                        title: 'Gotbootstrap Meeting',
                        url: 'http://gotbootstrap.com/',
                        start: YM + '-28',
                        className: "bg-info border-info text-white"
                    }
                ],
                viewSkeletonRender: function() {
                    $('.fc-toolbar .btn-default').addClass('btn-sm');
                    $('.fc-header-toolbar h2').addClass('fs-md');
                    $('#calendar').addClass('fc-reset-order')
                },

            });

            calendar.render();
        });
    </script>
</body>

</html>
