<template>
    <div class="pb-4">
        <div v-if="isAdmin == 1">
            <!-- name -->
            <div class="text-center md:text-left">
                <input type="text"
                    v-if="editEventName"
                    v-model="event.name"
                    @blur="editEventName = false; $emit('update')"
                    @keyup.enter="editEventName = false; $emit('update')"
                    @change="updateEvent"
                    v-focus
                    class="text-xl font-bold uppercase"
                >
                <div v-else>
                    <label @click="editEventName = true;" class="text-xl font-bold uppercase"> {{event.name}} </label>
                </div>
            </div>
            <!-- name end -->
            
            <!-- description -->
            <div class="max-w-xl pt-4 text-center md:text-left">
                <textarea type="text"
                    v-if="editEventDescription"
                    v-model="event.description"
                    @blur="editEventDescription = false; $emit('update')"
                    @keyup.enter="editEventDescription = false; $emit('update')"
                    @change="updateEvent"
                    v-focus
                    rows="4"
                    class="w-full text-sm font-semibold"
                > </textarea>
                <div v-else>
                    <label @click="editEventDescription = true;">
                        <div v-if="!event.description" class="text-sm font-semibold text-gray-500 uppercase">Description</div>
                        <div v-else class="text-sm font-semibold leading-snug">{{event.description}}</div>
                    </label>
                </div>
            </div>
            <!-- description end -->
        </div>

        <div v-else>
            <div class="text-xl font-bold text-center uppercase md:text-left"> {{event.name}} </div>
            <div class="max-w-xl pt-4 text-sm font-semibold leading-snug text-center md:text-left">{{event.description}} </div>
        </div>

    </div>
</template>

<script>
    export default {
        props:['isAdmin'],
        data(){
            return {
                editEventName: false,
                editEventDescription: false,
                event: '',
                originalEvent: '',
                errors: null,
            }
        },
        methods: {
            updateEvent() {
                var self = this;
                axios.put('/api/event-info',{
                    'name': self.event.name,
                    'description': self.event.description,
                }).then(
                    response =>{
                        self.event = response.data.data;
                        self.originalEvent = { ...self.event};
                    },error => {
                        self.errors = error;
                        self.event = self.originalEvent;
                    }
                );
                
            },
        },
        directives: {
            focus: {
                inserted (el) {
                    el.focus();
                }
            }
        },
        mounted() {
            //TODO: errors
            var self = this;
            axios.get('/api/event-info')
            .then(function(response){
                self.event = response.data.data;
                self.originalEvent = { ...self.event};
            });
        }
    }
</script>
