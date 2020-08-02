<template>
    <div class="flex flex-col items-center md:items-start">
        <div class="flex flex-row">
            <div class="flex flex-col md:flex-row">
                <div class="pr-1 text-xs font-normal tracking-tighter text-center uppercase">Invitation url: </div>
                <div class="flex flex-row">
                    <div class="w-64 text-xs font-normal tracking-tighter truncate cursor-default">{{ url }}</div>
                    <div @click.stop.prevent="copyUrl" class="hover:text-green-500">
                        <svg class="w-4 h-4 cursor-pointer fill-current" version="1.1" viewBox="0 0 512 512"  xmlns="http://www.w3.org/2000/svg">	
                            <path d="m456.53 153.6h-34.133v-51.2c-0.028-23.553-19.114-42.639-42.667-42.667h-35.706c-3.592-10.199-13.214-17.033-24.027-17.066h-17.067v-17.067c-0.015-14.132-11.468-25.585-25.6-25.6h-102.4c-14.132 0.015-25.585 11.468-25.6 25.6v17.067h-17.067c-10.813 0.033-20.435 6.868-24.028 17.067h-35.705c-23.552 0.027-42.639 19.113-42.666 42.666v332.8c0.028 23.553 19.114 42.639 42.667 42.667h102.4v8.533c0.015 14.132 11.468 25.585 25.6 25.6h256c14.132-0.015 25.585-11.468 25.6-25.6v-307.2c-0.016-14.132-11.469-25.585-25.601-25.6zm-290.13-128c6e-3 -4.71 3.823-8.527 8.533-8.533h102.4c4.71 6e-3 8.527 3.823 8.533 8.533v17.067h-119.47v-17.067zm-42.667 42.667c6e-3 -4.71 3.823-8.527 8.533-8.533h187.73c4.71 6e-3 8.527 3.823 8.533 8.533v34.133c-6e-3 4.71-3.823 8.527-8.533 8.533h-187.73c-4.71-6e-3 -8.527-3.823-8.533-8.533v-34.133zm51.2 110.93v281.6h-102.4c-14.132-0.015-25.585-11.468-25.6-25.6v-332.8c0.015-14.132 11.468-25.585 25.6-25.6h34.133v25.6c0.015 14.132 11.468 25.585 25.6 25.6h187.73c14.132-0.015 25.585-11.468 25.6-25.6v-25.6h34.133c14.132 0.015 25.585 11.468 25.6 25.6v51.2h-204.8c-14.132 0.015-25.584 11.468-25.6 25.6zm290.13 307.2c-6e-3 4.71-3.823 8.527-8.533 8.533h-256c-4.71-6e-3 -8.527-3.823-8.533-8.533v-307.2c6e-3 -4.71 3.823-8.527 8.533-8.533h256c4.71 6e-3 8.527 3.823 8.533 8.533v307.2z"/>
                            <path d="m405.33 256h-153.6c-4.713 0-8.533 3.82-8.533 8.533s3.82 8.533 8.533 8.533h153.6c4.713 0 8.533-3.82 8.533-8.533s-3.82-8.533-8.533-8.533z"/>
                            <path d="m405.33 298.67h-153.6c-4.713 0-8.533 3.82-8.533 8.533s3.82 8.533 8.533 8.533h153.6c4.713 0 8.533-3.82 8.533-8.533s-3.82-8.533-8.533-8.533z"/>
                            <path d="m405.33 341.33h-153.6c-4.713 0-8.533 3.82-8.533 8.533s3.82 8.533 8.533 8.533h153.6c4.713 0 8.533-3.82 8.533-8.533s-3.82-8.533-8.533-8.533z"/>
                            <path d="m405.33 384h-153.6c-4.713 0-8.533 3.821-8.533 8.533 0 4.713 3.82 8.533 8.533 8.533h153.6c4.713 0 8.533-3.821 8.533-8.533 1e-3 -4.712-3.82-8.533-8.533-8.533z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <input type="hidden" id="url-tmp" :value="url">
        </div>
    </div>
</template>

<script>
    export default {
        props:['url'],
        data(){
            return {}
        },
        methods: {
            copyUrl() {
                let codeToCopy = document.querySelector('#url-tmp')
                codeToCopy.setAttribute('type', 'text')
                codeToCopy.select()

                try {
                    var successful = document.execCommand('copy');
                } catch (err) {
                    alert('Oops, unable to copy');
                }

                /* unselect the range */
                codeToCopy.setAttribute('type', 'hidden')
                window.getSelection().removeAllRanges()
            },
        },
        directives: {
            focus: {
                inserted (el) {
                    el.focus();
                }
            }
        },
        mounted (){
            document.getElementById('url-tmp').setAttribute('readonly', 'readonly');
        }
    }
</script>
