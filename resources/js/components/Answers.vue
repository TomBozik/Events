<template>
    <div class="flex flex-col lg:flex-row">
        <!-- <div class="flex flex-row pb-1 pr-0 lg:pr-4"> -->
            <!-- <div class="font-bold text-center md:text-left">Date:</div> -->
            <div class="self-center pb-2 pr-0 lg:pb-0 lg:pr-2"><date-picker v-model="date" range :valueType="dateFormatSend" :format="dateFormat" placeholder="DATE"></date-picker></div>
            <button @click="submitAnswer" class="self-center px-24 py-1 text-lg font-bold tracking-wide text-white uppercase bg-black rounded-sm appearance-none lg:px-12 hover:text-orange-500 focus:outline-none">Add date</button>
        <!-- </div> -->
        <!-- <div class="flex flex-col">
            <div class="pt-6 font-bold text-center uppercase md:text-left lg:text-center md:pt-0">Your Dates:</div>
            <div v-for="answer in answers" :key="answer.id" class="font-semibold tracking-wide text-center md:text-left lg:text-center">{{ answer.from }} - {{ answer.to }}  <button v-on:click="deleteAnswer(answer.id)" class="text-xs font-semibold text-red-500 appearance-none hover:text-red-700 focus:outline-none">DELETE</button> </div>
        </div> -->
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
                answers: [],
                errors: null,
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
                        self.answers.push(response.data.data);
                        self.date = null;
                        this.$root.$refs.PersonsList.getPersons();
                    },error => {
                        self.errors = error;
                    }
                );
            },
            deleteAnswer(id){
                var self = this;
                axios.delete(`/api/answer/${id}`).then(
                    response =>{
                        self.answers = self.answers.filter(obj => obj.id !== id);
                        this.$root.$refs.PersonsList.getPersons();
                    },error => {
                        self.errors = error;
                    }
                );
            }
        },
        mounted() {
            //TODO: errors
            var self = this;
            axios.get('/api/my-answers')
            .then(function(response){
                self.answers = response.data.data;
            });
        }
    }
</script>
