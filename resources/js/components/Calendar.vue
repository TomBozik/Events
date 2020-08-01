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
                overlaps: null,
                calendarOptions: {
                    plugins: [ dayGridPlugin ],
                    initialView: 'dayGridMonth',
                    firstDay:1,
                    events: [
                        // { title: 'LONGEST - 3/5 (except: Jano, Fero)', start: '2020-08-17', end: '2020-08-21', textColor: 'white', color:'gray' },
                        // { title: 'EVERYONE', start: '2020-08-18', end: '2020-08-21', textColor: 'white',  color:'black'},
                        // { title: 'EVERYONE', start: '2020-08-05', end: '2020-08-07', textColor: 'white',  color:'black'},
                        // { title: 'EVERYONE', start: '2020-08-28', end: '2020-08-31', textColor: 'white',  color:'black'},

                    ],  
                    eventColor: 'black',
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
        },
        mounted() {
        var self = this;
        axios.get('/api/event-overlaps')
        .then(function(response){
            self.calendarOptions.events = JSON.parse(response.data.data);
        });
    }
    }
</script>
