<template lang="html">
    <div>
        <table class="table table-striped">
            <tbody>
                <tr v-for="status in statuses">
                  <td>{{status.description}}</td>
                <td>{{status.image}}</td>
                  <td>{{status.created_at}}</td>
              </tr>
            </tbody>
        </table>
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
