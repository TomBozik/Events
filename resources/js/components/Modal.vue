<template>
  <div>

    <div v-if="showModal" class="fixed inset-0 z-40 flex items-center w-full h-full overflow-auto">

      <div class="relative z-50 max-w-full p-3 mx-auto my-0" style="width: 600px;">
        <div class="flex flex-col overflow-hidden bg-white border rounded shadow-lg">

          <div class="px-8 pt-4 pb-2 text-center">
            <h3 class="text-lg font-semibold uppercase">Your Code</h3>
          </div>

            <div class="pt-2 text-xl font-bold tracking-wide text-center">
                {{ personCode }}
            </div>
            <div class="px-12 pt-4 text-xs text-center">
                Please save this code, in the future you will not be able to log in to this event without it. If you entered an email when registering, we have sent you this code there as well.
                <span class="font-semibold text-red-700 text-md">You will not see this code again.</span>
            </div>

          <div class="flex items-center justify-center p-2">
            <button class="px-6 py-1 mb-1 mr-1 text-sm font-bold text-red-500 uppercase outline-none hover:text-red-700 focus:outline-none" type="button" v-on:click="toggleModal()">Close</button>
          </div>

        </div>
      </div>

      <div class="fixed inset-0 z-40 w-full h-full overflow-auto bg-black opacity-50"></div>
    </div>
    
  </div>
</template>

<script>
export default {
  name: 'Modal',
  props: ['personCode'],
  data() {
    return {
      showModal: true,
    }
  },
  methods:{
    toggleModal: function(){
      this.showModal = !this.showModal;
    },
  }
}
</script>