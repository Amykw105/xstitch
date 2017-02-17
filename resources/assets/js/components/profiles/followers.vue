<template lang="html">
    <div>
        <button v-if="status === true" type="button" class="btn btn-warning" v-on:click="unfollow()">
          Unfollow
        </button>
        <button  v-if="status === false"  class="btn btn-primary" v-on:click="follow()">
          Follow
        </button>


    <h3>Followers</h3>
      <table class="table table-striped">
          <tbody>
              <tr v-for="follower in followers" v-bind:user="follower"
                  v-on:update-user="fetchFollowers">
              <td><a href="/" :href="follower.slug">{{follower.name}}</a></td>
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
        currentslug: '',
        currentid: ''
    },
    data(){
        return {
            status: '',
            newFollow: {
              followee: this.userid,
              follower: this.currentid
            },
            followers: [],
            followees: [],
        }
    },
    created(){
        this.fetchAction();
        this.fetchFollowers();
        this.fetchFollowees();
    },
    methods: {
        fetchAction(){
          axios.get('/api/' + this.currentslug + '/follow/' + this.userslug).then(response => {
              this.status = response.data.followstatus;
          });
        },
        follow(newFollow){
          axios.post('/api/' + this.currentslug + '/follow/' + this.userslug, this.newFollow).then(response => {
              this.fetchAction();
              this.fetchFollowers();
            }, response => {
                  console.log = response.data;
              });
        },
        unfollow(followid){
          axios.delete('/api/' + this.currentslug + '/follow/' + this.userslug).then(response => {
            this.fetchAction();
            this.fetchFollowers();
          });
        },
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
