<template lang="html">
    <div>
        <button  v-if="status" type="button" class="btn btn-warning" v-on:click="unfollow()">
          Unfollow
        </button>
        <button  v-else type="button" class="btn btn-primary" v-on:click="follow()">
          Follow
        </button>
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
        }
    },
    created(){
        this.fetchAction();
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
            }, response => {
                  console.log = response.data;
              });
        },
        unfollow(followid){
          axios.delete('/api/' + this.currentslug + '/follow/' + this.userslug).then(response => {
            this.fetchAction();
          });
        },
    } // end methods
}
</script>
