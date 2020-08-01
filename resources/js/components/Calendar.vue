<template>
    <div class="mx-2">
        <FullCalendar :options="calendarOptions" />
    </div>
</template>

<script>

    import FullCalendar from '@fullcalendar/vue'
    import dayGridPlugin from '@fullcalendar/daygrid'
    
    export default {
        components:{
            FullCalendar,
        },
        data(){
            return {
                calendarOptions: {
                    plugins: [ dayGridPlugin ],
                    initialView: 'dayGridMonth',
                    // eventDidMount: this.handleEventMount,
                    events: [
                        { title: '(4)', start: '2020-08-16', end: '2020-08-21', description: 'description for Long Event', textColor: 'white' },
                    ],
                    // eventColor: '#378006',
                    headerToolbar: {
                        left: '',
                        center: '',
                        right: ''
                    },
                    footerToolbar: {
                        left: 'title',
                        center: '',
                        right: 'prev,next'
                    },
                }
            }
        },
        methods: {
            // handleEventMount: function(info) {
            //     var tooltip = new Tooltip(info.el, {
            //         title: info.event.extendedProps.description,
            //         placement: 'top',
            //         trigger: 'hover',
            //         container: 'body'
            //     });
            // },
        },
        mounted() {
        }
    }
</script>
