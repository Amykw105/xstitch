<template lang="html">
    <div>
      <div class="modal fade" tabindex="-1" role="dialog" id="newStatusModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Add a new status</h4>
          </div>
          <div class="modal-body">
            <form v-on:submit.prevent="createStatus" method="post">
                <div v-bind:class="{'form-group': true, 'has-error': errors.description}">
                    <label>Status Description:</label>
                    <input type="text" v-model="newStatus.description" class="form-control">
                    <span class="help-block" v-for="error in errors.description">{{ error }}</span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save New Status</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /. New Status modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id="updateStatusModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Add a new status</h4>
        </div>
        <div class="modal-body">
          <form v-on:submit.prevent="updateStatus" method="post">
            <input type="hidden" name="_method" value="PATCH">
              <div v-bind:class="{'form-group': true, 'has-error': errors.description}">
                  <label>Status Description:</label>
                  <input type="text" v-model="editStatus.description" class="form-control">
                  <span class="help-block" v-for="error in errors.description">{{ error }}</span>
              </div>
              <div class="form-group">
                  <button type="submit" class="btn btn-primary">Save New Status</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /. New Status modal -->


    <button type="button" data-toggle="modal" data-target="#newStatusModal" class="btn btn-primary">New Status</button>
        <table class="table table-striped">
            <thead>
                <tr>
                  <th>image</th>
                  <th>Description</th>
                  <th>Posted</th>
                  <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="status in statuses" v-bind:user="status"
                    v-on:update-user="fetchStatuses"
                >
                <td style="color: black">{{status.image}}</td>
                <td style="color: black">{{status.description}}</td>
                <td style="color: black">{{status.created_at}}</td>

                <td>

                  <button type="button" class="btn btn-warning" v-on:click="fetchStatus(status)">
                    Edit
                  </button>
                  <button type="button" class="btn btn-danger" v-on:click="deleteStatus(status)">
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
      userslug: '',
      projectslug: '',
      projectid: ''
    },
    data(){
        return {
            statuses: [],
            errors: [],
            newStatus:{
              project_id: this.projectid,
              description: '',
              image: 'google.com',
            },
            editStatus:{
              id: '',
              description: '',
              image: '',
            },
        }
    },
    created(){
        this.fetchStatuses();
    },
    methods: {
        fetchStatuses(){ // Get all statuses for the listing
          axios.get('/api/' + this.userslug + '/' + this.projectslug + '/statuses').then(response => {
              this.statuses = response.data.data;
          });
        },
        createStatus(){
          axios.post('/api/' + this.userslug + '/' + this.projectslug + '/statuses', this.newStatus).then(response => {
              console.log(response.data);
              this.fetchStatuses();
          }, response => {
              this.formErrors = response.data;
          });
          this.newStatus = {'description':''};
          $("#newStatusModal").modal("hide");
        },
        fetchStatus(status) { // Get individual status for editing
          axios.get('/api/' + this.userslug + '/' + this.projectslug + '/statuses/' + status.id).then(response => {
            this.editStatus.description = response.data.data[0].description;
            this.editStatus.id = response.data.data[0].id;
            this.editStatus.image = response.data.data[0].image;
            $("#updateStatusModal").modal("show");
          }, response => {
              this.formErrors = response.data;
          });
        },
        updateStatus(editStatus){
            axios.patch('/api/' + this.userslug + '/' + this.projectslug + '/statuses/' + this.editStatus.id, this.editStatus).then(response => {
              console.log(response);
              this.fetchStatuses();
            }, response => {
                console.log('fail');
            });
            $("#updateStatusModal").modal("hide");

        },
        deleteStatus(status){
              axios.delete('/api/' + this.userslug + '/' + this.projectslug + '/statuses/' + status.id).then(response => {
                   let index = this.statuses.indexOf(status);
                   this.statuses.splice(index, 1);
                  this.fetchStatuses();
              });
          },
    } // end methods
}
</script>
