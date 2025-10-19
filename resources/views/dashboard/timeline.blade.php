<x-app-layout>
    {{-- Main component container --}}
    <div x-data="calendarBoard({ boards: @js($boards) })" x-init="init()"
        class="rounded-xl border border-slate-200 dark:border-white/10 dark:bg-card-dark  overflow-hidden shadow-sm p-4 sm:p-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-2">
                <button @click="prevPeriod()"
                    class="rounded-full p-2 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-slate-600 dark:text-slate-300">chevron_left</span>
                </button>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white whitespace-nowrap" x-text="periodLabel">
                </h3>
                <button @click="nextPeriod()"
                    class="rounded-full p-2 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-slate-600 dark:text-slate-300">chevron_right</span>
                </button>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 rounded-lg bg-slate-100 dark:bg-card-dark p-1 text-sm">
                    {{-- <button @click="setView('week')"
                        :class="{ 'bg-white dark:bg-slate-700 text-primary dark:text-white shadow': currentView === 'week', 'text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700': currentView !== 'week' }"
                        class="px-3 py-1 rounded-md font-medium transition-colors">Week</button> --}}
                    <button @click="setView('month')"
                        :class="{ 'bg-white dark:bg-card-dark/90 text-primary dark:text-white shadow': currentView === 'month', 'text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700': currentView !== 'month' }"
                        class="px-3 py-1 rounded-md font-medium transition-colors">Month</button>
                    {{-- <button @click="setView('year')"
                        :class="{ 'bg-white dark:bg-slate-700 text-primary dark:text-white shadow': currentView === 'year', 'text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700': currentView !== 'year' }"
                        class="px-3 py-1 rounded-md font-medium transition-colors">Year</button> --}}
                </div>
                <button
                    class="flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium bg-slate-100 dark:bg-card-dark/90 text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                    <span class="material-symbols-outlined text-base">filter_list</span>
                    Filter Boards
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <div class="grid" :style="`grid-template-columns: 150px minmax(0, 1fr);`">
                <div class="sticky left-0 z-20 bg-white dark:bg-card-dark">
                    <div class="h-12 border-b border-r border-slate-200 dark:border-white/10"></div>
                    <template x-for="project in projects" :key="project.id">
                        <div class="flex items-center p-4 border-b border-r border-slate-200 dark:border-white/10"
                            :style="{ height: (project.totalRows * 2.5) + 'rem', minHeight: '4rem' }">
                            <p class="font-semibold text-slate-800 dark:text-slate-100 truncate" x-text="project.name">
                            </p>
                        </div>
                    </template>
                </div>
                <div>
                    <div class="sticky top-0 z-10 bg-white dark:bg-card-dark grid"
                        :style="`grid-template-columns: repeat(${timeUnits.length}, minmax(${currentView === 'year' ? '90px' : '60px'}, 1fr));`">
                        <template x-for="unit in timeUnits" :key="unit.label">
                            <div class="text-center py-2 border-b border-slate-200 dark:border-white/10 h-12">
                                <p class="text-sm font-medium text-slate-700 dark:text-slate-300" x-text="unit.label">
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-400" x-text="unit.subLabel"></p>
                            </div>
                        </template>
                    </div>
                    <div>
                        <template x-for="project in projects" :key="project.id">
                            <div class="relative border-b border-slate-200 dark:border-white/10"
                                :style="{ height: (project.totalRows * 2.5) + 'rem', minHeight: '4rem' }">
                                <template x-for="task in project.tasks" :key="task.id">
                                    <div class="absolute px-1 z-10"
                                        :style="`
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            top: calc(${task.rowIndex} * 2.5rem + 0.25rem);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            height: 2rem;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            left: calc(100% / ${timeUnits.length} * (${task.colStart} - 1));
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            width: calc(100% / ${timeUnits.length} * ${task.colSpan});
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        `">
                                        <div
                                            :class="`rounded-lg p-2 w-full h-full flex items-center shadow-sm ${task.color}`">
                                            <p class="text-xs font-medium truncate" x-text="task.title"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calendarBoard({
            boards
        }) {
            const startOfDay = (date) => {
                const newDate = new Date(date);
                newDate.setHours(0, 0, 0, 0);
                return newDate;
            };

            const dayOfYear = (date) => {
                const start = new Date(date.getFullYear(), 0, 0);
                const diff = (date - start) + ((start.getTimezoneOffset() - date.getTimezoneOffset()) * 60 * 1000);
                return Math.floor(diff / (1000 * 60 * 60 * 24));
            };

            return {
                // State
                currentView: 'month',
                currentDate: new Date(),
                allBoards: boards,
                projects: [],
                timeUnits: [],

                init() {
                    this.updateCalendarData();
                },

                setView(view) {
                    this.currentView = view;
                    this.updateCalendarData();
                },
                get periodLabel() {
                    const options = {
                        year: 'numeric'
                    };
                    switch (this.currentView) {
                        case 'month':
                            return this.currentDate.toLocaleDateString('en-US', {
                                month: 'long',
                                year: 'numeric'
                            });
                        case 'year':
                            return this.currentDate.getFullYear();
                        case 'week':
                            const startOfWeek = new Date(this.currentDate);
                            const day = startOfWeek.getDay();
                            const diff = startOfWeek.getDate() - day + (day === 0 ? -6 : 1);
                            startOfWeek.setDate(diff);
                            const endOfWeek = new Date(startOfWeek);
                            endOfWeek.setDate(startOfWeek.getDate() + 6);

                            const startMonth = startOfWeek.toLocaleString('en-US', {
                                month: 'short'
                            });
                            const endMonth = endOfWeek.toLocaleString('en-US', {
                                month: 'short'
                            });

                            if (startOfWeek.getFullYear() !== endOfWeek.getFullYear()) {
                                return `${startMonth} ${startOfWeek.getDate()}, ${startOfWeek.getFullYear()} - ${endMonth} ${endOfWeek.getDate()}, ${endOfWeek.getFullYear()}`;
                            }
                            if (startMonth !== endMonth) {
                                return `${startMonth} ${startOfWeek.getDate()} - ${endMonth} ${endOfWeek.getDate()}, ${endOfWeek.getFullYear()}`;
                            }
                            return `${startMonth} ${startOfWeek.getDate()} - ${endOfWeek.getDate()}, ${endOfWeek.getFullYear()}`;
                    }
                    return '';
                },

                updateCalendarData() {
                    let startDate, endDate;
                    const year = this.currentDate.getFullYear();
                    const month = this.currentDate.getMonth();

                    switch (this.currentView) {
                        case 'week':
                            startDate = startOfDay(this.currentDate);
                            const dayOfWeek = startDate.getDay();
                            const diff = startDate.getDate() - dayOfWeek + (dayOfWeek === 0 ? -6 : 1);
                            startDate.setDate(diff);

                            endDate = new Date(startDate);
                            endDate.setDate(startDate.getDate() + 6);
                            endDate.setHours(23, 59, 59, 999);

                            this.timeUnits = Array.from({
                                length: 7
                            }).map((_, i) => {
                                const d = new Date(startDate);
                                d.setDate(startDate.getDate() + i);
                                return {
                                    label: d.getDate(),
                                    subLabel: d.toLocaleString('en-US', {
                                        weekday: 'short'
                                    })
                                };
                            });
                            break;

                        case 'year':
                            startDate = new Date(year, 0, 1);
                            endDate = new Date(year, 11, 31, 23, 59, 59, 999);
                            this.timeUnits = Array.from({
                                length: 12
                            }).map((_, i) => ({
                                label: new Date(year, i, 1).toLocaleDateString('en-US', {
                                    month: 'short'
                                }),
                                subLabel: ''
                            }));
                            break;

                        case 'month':
                        default:
                            startDate = new Date(year, month, 1);
                            endDate = new Date(year, month + 1, 0, 23, 59, 59, 999);
                            const daysInMonth = endDate.getDate();
                            this.timeUnits = Array.from({
                                length: daysInMonth
                            }).map((_, i) => {
                                const d = new Date(year, month, i + 1);
                                return {
                                    label: i + 1,
                                    subLabel: d.toLocaleString('en-US', {
                                        weekday: 'short'
                                    })
                                };
                            });
                            break;
                    }


                    this.projects = this.allBoards.map(board => {
                        let visibleTasks = board.tasks.map(task => {

                            const taskStart = startOfDay(task.soft_due_date ?? task.hard_deadline);
                            const taskEnd = startOfDay(task.hard_deadline);

                            if (taskEnd < startDate || taskStart > endDate) return null;

                            let colStart, colSpan;

                            if (this.currentView === 'year') {
                                const daysInYear = (year % 4 === 0 && year % 100 !== 0) || year % 400 ===
                                    0 ? 366 : 365;
                                const start = taskStart < startDate ? startDate : taskStart;
                                const end = taskEnd > endDate ? endDate : taskEnd;

                                const startDay = dayOfYear(start);
                                const endDay = dayOfYear(end);


                                colStart = (startDay / daysInYear) * 12 + 1;
                                colSpan = ((endDay - startDay + 1) / daysInYear) * 12;

                            } else {
                                const start = taskStart < startDate ? startDate : taskStart;
                                const end = taskEnd > endDate ? endDate : taskEnd;

                                const startPos = Math.round((start - startDate) / (1000 * 60 * 60 * 24));
                                const endPos = Math.round((end - startDate) / (1000 * 60 * 60 * 24));

                                colStart = startPos + 1;
                                colSpan = endPos - startPos + 1;
                            }

                            return {
                                ...task,
                                colStart: colStart,
                                colSpan: Math.max(colSpan,
                                    0.05),
                                color: getTaskColor(task.priority),
                                rowIndex: 0
                            };
                        }).filter(Boolean);


                        visibleTasks.sort((a, b) => a.colStart - b.colStart);
                        const taskRows = [];
                        visibleTasks.forEach(task => {
                            let placed = false;
                            for (let i = 0; i < taskRows.length; i++) {
                                const lastTaskInRow = taskRows[i][taskRows[i].length - 1];
                                if (task.colStart >= (lastTaskInRow.colStart + lastTaskInRow.colSpan -
                                        0.01)) { // Small tolerance
                                    task.rowIndex = i;
                                    taskRows[i].push(task);
                                    placed = true;
                                    break;
                                }
                            }
                            if (!placed) {
                                task.rowIndex = taskRows.length;
                                taskRows.push([task]);
                            }
                        });

                        return {
                            id: board.id,
                            name: board.name,
                            tasks: visibleTasks,
                            totalRows: taskRows.length || 1,
                        };
                    });
                },


                nextPeriod() {
                    const newDate = new Date(this.currentDate);
                    switch (this.currentView) {
                        case 'week':
                            newDate.setDate(newDate.getDate() + 7);
                            break;
                        case 'year':
                            newDate.setFullYear(newDate.getFullYear() + 1);
                            break;
                        case 'month':
                            newDate.setMonth(newDate.getMonth() + 1);
                            break;
                    }
                    this.currentDate = newDate;
                    this.updateCalendarData();
                },
                prevPeriod() {
                    const newDate = new Date(this.currentDate);
                    switch (this.currentView) {
                        case 'week':
                            newDate.setDate(newDate.getDate() - 7);
                            break;
                        case 'year':
                            newDate.setFullYear(newDate.getFullYear() - 1);
                            break;
                        case 'month':
                            newDate.setMonth(newDate.getMonth() - 1);
                            break;
                    }
                    this.currentDate = newDate;
                    this.updateCalendarData();
                }
            };
        }

        function getTaskColor(priority) {
            switch (priority) {
                case 'high':
                    return 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100/90';
                case 'medium':
                    return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300';
                case 'low':
                    return 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-300';
                default:
                    return 'bg-slate-300 text-slate-800';
            }
        }
    </script>
</x-app-layout>
