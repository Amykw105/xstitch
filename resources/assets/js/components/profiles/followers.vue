<template lang="html">
    <div>
      <h3>Followers</h3>
        <table class="table table-striped">
            <tbody>
                <tr v-for="follower in followers" v-bind:user="follower"
                    v-on:update-user="fetchFollowers">
                <td><a :href="follower.slug">{{follower.name}}</a></td>
              </tr>
            </tbody>
        </table>
        <h3>Following</h3>
        <table class="table table-striped">
            <tbody>
                <tr v-for="followee in followees" v-bind:user="followee"
                    v-on:update-user="fetchFollowees">
                <td><a href="/" :href="followee.slug">{{followee.name}}</a></td>
              </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
      userslug: '',
        userid: '',
    },
    data(){
        return {
            followers: [],
            followees: [],
        }
    },
    created(){
        this.fetchFollowers();
        this.fetchFollowees();
    },
    methods: {
        fetchFollowers(){ // Get all Followers
          axios.get('/api/' + this.userslug + '/followers').then(response => {
              this.followers = response.data.followers;
          });
        },
        fetchFollowees(){ // Get all Followers
          axios.get('/api/' + this.userslug + '/following').then(response => {
              this.followees = response.data.followees;

          });
        },
    } // end methods
}
</script>
