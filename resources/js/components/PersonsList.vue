<template>
    <div class="flex flex-col w-full md:w-72">
        <div class="text-xl font-bold text-center uppercase">Event Persons</div>
        <div class="w-32 h-1 mx-auto my-1 bg-gray-300 rounded-full sm:hidden"></div>
        <div class="grid grid-cols-2 sm:grid-cols-1">
            <div v-for="person in persons" :key="person.id" class="px-2">
                <div class="flex flex-col pt-2 font-semibold text-center text-md">
                    <button v-if="isAdmin == 1" v-on:click="deletePerson(person.id)" class="appearance-none focus:outline-none hover:text-red-700" :class="person.id == personId ? 'font-extrabold' : 'font-semibold'">{{ person.username }}</button>
                    <div v-else :class="person.id == personId ? 'font-extrabold' : 'font-semibold'">{{ person.username }}</div>
                </div>
                <div v-for="answer in person.answers" :key="answer.id" class="pb-1 text-sm text-center">
                    <button v-if="person.id == personId" :class="person.id == personId ? 'font-bold hover:text-red-500 appearance-none focus:outline-none' : ''" v-on:click="deleteAnswer(answer.id)" >{{ answer.from }} - {{ answer.to }}</button>
                    <div v-else :class="person.id == personId ? 'font-bold' : ''">{{ answer.from }} - {{ answer.to }}</div>
                </div>
                <div v-if="person.id == personId" class="hidden w-32 h-1 mx-auto my-1 bg-gray-300 rounded-full sm:block"></div>
            </div>
        </div>
        <!-- {{ isAdmin }} -->
    </div>
</template>

<script>
    export default {
        props:['isAdmin', 'personId'],
        data(){
            return {
                persons: [],
                errors: null,
            }
        },
        methods:{
            deletePerson(id){
                var self = this;
                axios.delete(`/api/person/${id}`).then(
                    response =>{
                        self.persons = self.persons.filter(obj => obj.id !== id);
                    },error => {
                        self.errors = error;
                    }
                );
            },
            deleteAnswer(id){
                var self = this;
                axios.delete(`/api/answer/${id}`).then(
                    response =>{
                        // self.answers = self.answers.filter(obj => obj.id !== id);
                        self.getPersons();
                        this.$root.$refs.Calendar.getEventOverlaps();
                    },error => {
                        self.errors = error;
                    }
                );
            },
            getPersons(){
                var self = this;
                axios.get('/api/event-persons').then(
                    response =>{
                        self.persons = response.data.data;
                        // move logged person to start of array
                        self.persons.some((person, idx) => person.id == self.personId && self.persons.unshift(self.persons.splice(idx,1)[0]))

                    },error => {
                        self.errors = error;
                    }
                );
            }
        },
        mounted() {
            this.getPersons();
        },
        created(){
            this.$root.$refs.PersonsList = this;
        },
    }
</script>
