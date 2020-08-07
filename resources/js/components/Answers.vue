<template>
<div>
    <div class="flex flex-col lg:flex-row">
        <div class="self-center pb-2 pr-0 lg:pb-0 lg:pr-2"><date-picker v-model="date" range :valueType="dateFormatSend" :format="dateFormat" :lang="lang" placeholder="DATE"></date-picker></div>
        <button @click="submitAnswer" class="self-center px-24 py-1 text-lg font-bold tracking-wide text-white uppercase bg-black rounded-sm appearance-none lg:px-12 hover:text-orange-500 focus:outline-none">Add date</button>
    </div>
    <div v-if="errors" class="text-xs font-semibold text-red-500 uppercase">{{errors}}</div>
</div>
</template>

<script>

    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    
    export default {
        components:{
            DatePicker,
        },
        data(){
            return {
                date: null,
                dateFormat:"DD.MM.YYYY",
                dateFormatSend:"YYYY-MM-DD",
                errors: null,
                lang: {
                    formatLocale: {
                        firstDayOfWeek: 1,
                    },
                },
            }
        },
        methods: {
            submitAnswer() {
                var self = this;
                axios.post('/api/answer',{
                    'from': self.date[0],
                    'to': self.date[1],
                }).then(
                    response =>{
                        self.date = null;
                        this.$root.$refs.PersonsList.getPersons();
                        this.$root.$refs.Calendar.getEventOverlaps();
                        self.errors = null;
                    },error => {
                        self.errors = error.response.data.error;
                    }
                );
            },
        },
        mounted() {
            document.getElementsByClassName('mx-input')[0].setAttribute('readonly', 'readonly');
        }
    }
</script>
