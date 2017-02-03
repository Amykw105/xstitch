<template lang="html">
    <div>
      <div class="modal fade" tabindex="-1" role="dialog" id="newProjectModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Create a new project</h4>
          </div>
          <div class="modal-body">
            <form v-on:submit.prevent="createProject" method="post">

                <div v-bind:class="{'form-group': true, 'has-error': errors.name}">
                    <label>Project Name:</label>
                    <input type="text" v-model="newProject.name" class="form-control">
                    <span class="help-block" v-for="error in errors.name">{{ error }}</span>
                </div>
                <div v-bind:class="{'form-group': true, 'has-error': errors.description}">
                    <label>Project Description:</label>
                    <input type="text" v-model="newProject.description" class="form-control">
                    <span class="help-block" v-for="error in errors.description">{{ error }}</span>
                </div>
                <div v-bind:class="{'form-group': true, 'has-error': errors.source}">
                    <label>Project Source:</label>
                    <input type="text" v-model="newProject.source" class="form-control">
                    <span class="help-block" v-for="error in errors.source">{{ error }}</span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create New Project</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /. New Project modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id="updateProjectModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Update your project</h4>
        </div>
        <div class="modal-body">
          <form v-on:submit.prevent="updateProject(editProject)" method="post">
            <input type="hidden" name="_method" value="PATCH">
              <div v-bind:class="{'form-group': true, 'has-error': errors.description}">
                  <label>Project Description:</label>
                  <input type="text" v-model="editProject.description" class="form-control">
                  <span class="help-block" v-for="error in errors.description">{{ error }}</span>
              </div>
              <div v-bind:class="{'form-group': true, 'has-error': errors.source}">
                  <label>Project Source:</label>
                  <input type="text" v-model="editProject.source" class="form-control">
                  <span class="help-block" v-for="error in errors.source">{{ error }}</span>
              </div>
              <div class="form-group">
                  <button type="submit" class="btn btn-primary">Update Project</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /. Update Project modal -->
  <h3>Projects</h3>
    <button type="button" data-toggle="modal" data-target="#newProjectModal" v-if="permissions == 'true'" class="btn btn-primary pull-right">New Project</button>
        <table class="table table-striped">
            <thead>
                <tr>
                  <th>id</th>
                  <th>Projectname</th>
                  <th>Description</th>
                  <th></th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="project in projects" v-bind:user="project"
                    v-on:update-user="fetchProjects"
                >
                <td>{{project.id}}</td>
                <td>{{project.name}}</td>
                <td>{{project.description}}</td>
                <td>
                  <a :href="'/' + userslug + '/' + project.slug" class="btn btn-info">
                    View
                  </a>
                  <button v-if="permissions == 'true'" type="button" class="btn btn-warning" v-on:click="fetchProject(project)">
                    Edit
                  </button>
                  <button v-if="permissions == 'true'" type="button" class="btn btn-danger" v-on:click="deleteProject(project)">
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
      userslug: {
            type: String,
            default: "",
        },
        userid: '',
        permissions: {
          default: false
        }
    },
    data(){
        return {
            projects: [],
            errors: [],
            newProject:{
              name: '',
              user_id: this.userid,
              description: '',
              source: '',
              slug: '',
            },
            editProject:{
              id: '',
              owner_id: this.userid,
              description: '',
              source: '',
              name: '',
              slug: ''
            }
        }
    },
    created(){
        this.fetchProjects();
    },
    computed: {
      slug: function() {
        var slug = this.sanitizeTitle(this.newProject.name);
        return slug;
      }
    },
    methods: {
        fetchProjects(){ // Get all projects for the listing
          axios.get('/api/' + this.userslug + '/projects').then(response => {
              this.projects = response.data.data;
          });
        },
        fetchProject(project) { // Get individual project for editing
          axios.get('/api/' + this.userslug + '/projects/' + project.id).then(response => {
            this.editProject.description = response.data.description;
            this.editProject.source = response.data.source;
            this.editProject.id = response.data.id;
            this.editProject.name = response.data.name;
            this.editProject.slug = response.data.slug;
            this.editProject.owner_id = response.data.owner_id;
            $("#updateProjectModal").modal("show");
          }, response => {
              this.formErrors = response.data;
          });
    		},
        createProject(){
            this.newProject.slug = this.slug;
            axios.post('/api/' + this.userslug + '/projects', this.newProject).then(response => {
                console.log(response.data);
                this.fetchProjects();
            }, response => {
                this.formErrors = response.data;
            });
            this.newProject = {'name':'','description':'','source':''};
            $("#newProjectModal").modal("hide");

        },
        updateProject(editProject){
            axios.patch('/api/' + this.userslug + '/projects/' + this.editProject.id, this.editProject).then(response => {
                console.log('success');
                this.fetchProjects();
            }, response => {
                console.log('fail');
            });
            $("#updateProjectModal").modal("hide");

        },
        deleteProject(project){
              axios.delete('/api/' + this.userslug + '/projects/' + project.id).then(response => {
                   let index = this.projects.indexOf(project);
                   this.projects.splice(index, 1);
                  this.fetchProjects();
              });
          },
        sanitizeTitle: function(title) {
          var slug = "";
          var titleLower = title.toLowerCase();
          slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');// Letter "e"
          slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a');// Letter "a"
          slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o');// Letter "o"
          slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u'); // Letter "u"
          slug = slug.replace(/đ/gi, 'd');// Letter "d"
          slug = slug.replace(/\s*$/g, '');// Trim the last whitespace
          slug = slug.replace(/\s+/g, '-');// Change whitespace to "-"
          return slug;
        }
    } // end methods
}
</script>
