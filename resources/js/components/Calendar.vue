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
                    events: [
                        // { title: '4 persons', start: '2020-07-11', end: '2020-07-19', color: 'green' },
                        // { title: '4 persons', start: '2020-07-26', end: '2020-08-02', color: 'black' },
                        // { title: '6 persons', start: '2020-07-17', end: '2020-07-24', color: 'blue' },
                    ],
                    eventColor: '#378006',
                    headerToolbar: {
                        left: '',
                        center: '',
                        right: ''
                    },
                    footerToolbar: {
                        left: '',
                        center: '',
                        right: 'prev,next'
                    },
                }
            }
        },
        methods: {
        },
        mounted() {
            // //TODO: errors
            // var self = this;
            // axios.get('/api/my-answers')
            // .then(function(response){
            //     self.answers = response.data.data;
            // });
        }
    }
</script>
