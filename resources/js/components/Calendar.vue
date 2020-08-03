<template>
    <div class="pb-1 mx-1 md:flex-1 md:h-auto h-150">
        <FullCalendar ref="fullCalendar" :options="calendarOptions" />
    </div>
</template>

<script>

    import FullCalendar from '@fullcalendar/vue'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import interactionPlugin from '@fullcalendar/interaction'
    
    export default {
        components:{
            FullCalendar,
        },
        data(){
            return {
                overlaps: null,
                plugins: [ dayGridPlugin ],
                calendarOptions: {
                    plugins: [ dayGridPlugin,interactionPlugin ],
                    initialView: 'dayGridMonth',
                    firstDay:1,
                    height: '100%',
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
            getEventOverlaps() {
                //delete old
                let calendarApi = this.$refs.fullCalendar.getApi();
                let events = calendarApi.getEvents();
                for (let i = 0; i < events.length; i++){
                    events[i].remove();
                }

                //load new
                var self = this;
                axios.get('/api/event-overlaps')
                .then(function(response){
                    let calendarApi = self.$refs.fullCalendar.getApi();
                    let events = [];
                    events = JSON.parse(response.data.data);
                    for (let i = 0; i < events.length; i++){
                        calendarApi.addEvent(events[i]);
                    }
                });
            },
        },
        mounted() {
            this.getEventOverlaps();
        },
        created(){
            this.$root.$refs.Calendar = this;
        },
    }
</script>

<style>
.fc .fc-toolbar-title{
    font-size: 1.2em;
    margin: 0;
    text-transform: uppercase;
}
.fc-scroller { overflow-y: hidden !important; }
</style>
