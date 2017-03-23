<template lang="html">
    <div class="status-section">
      <div class="status_grid">
          <div class="status_block" v-for="status in statuses"
              v-on:update-user="fetchStatuses">
              <div class="status_image">
                <img :alt="status.description" :src="status.image" />
              </div>
              <span class="status_info">{{status.description}}<br/>{{status.created_at}}</span>
          </div>
          <div class="clearfix"></div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        userid: '',
        userslug: ''
    },
    data(){
        return {
            statuses: [],
        }
    },
    created(){
        this.fetchStatuses();
    },
    methods: {
        fetchStatuses(){ // Get all Followers
          axios.get('/api/' + this.userslug + '/my-feed').then(response => {
              this.statuses = response.data.updates;
          });
        },
    } // end methods
}
</script>
