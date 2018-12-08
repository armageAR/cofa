<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2">Modificar Proveedor</h4>
          <div class="card-header-actions mr-1">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="update">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
            <a
              class="card-header-action ml-1"
              href="#"
              :disabled="submitingDestroy"
              @click.prevent="destroy"
            >
              <i class="fas fa-spinner fa-spin" v-if="submitingDestroy"></i>
              <i class="far fa-trash-alt" v-else></i>
              <span class="d-md-down-none ml-1">Eliminar</span>
            </a>
          </div>
        </div>
        <div class="card-body px-0">
          <div class="row" v-if="!loading">
            <div class="form-group col-md-9">
              <label>Nombre</label>
              <input
                type="text"
                class="form-control"
                :class="{'is-invalid': errors.name}"
                v-model="supplier.name"
              >
              <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
            </div>
            <div class="form-group col-md-3">
              <label>ID</label>
              <input class="form-control" type="text" v-model="supplier.id" readonly>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>CUIT</label>
                <input
                  type="text"
                  class="form-control"
                  :class="{'is-invalid': errors.taxNumber}"
                  v-model="supplier.taxNumber"
                >
                <div class="invalid-feedback" v-if="errors.taxNumber">{{errors.taxNumber[0]}}</div>
              </div>
              <div class="form-group">
                <label>Razon Social</label>
                <input
                  type="text"
                  class="form-control"
                  :class="{'is-invalid': errors.bussinesName}"
                  v-model="supplier.bussinesName"
                >
                <div class="invalid-feedback" v-if="errors.bussinesName">{{errors.bussinesName[0]}}</div>
              </div>
              <div class="form-group">
                <label>Abreviatura</label>
                <input
                  type="text"
                  class="form-control"
                  :class="{'is-invalid': errors.abbreviation}"
                  v-model="supplier.abbreviation"
                >
                <div class="invalid-feedback" v-if="errors.abbreviation">{{errors.abbreviation[0]}}</div>
              </div>

              <div class="form-group">
                <label class="col-form-label">Registrado</label>
                <p class="form-control-plaintext text-muted">{{supplier.created_at | moment("LLL")}}</p>
              </div>
            </div>
          </div>
          <div class="row" v-else>
            <div class="col-md-12">
              <content-placeholders>
                <content-placeholders-text/>
              </content-placeholders>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      supplier: {},
      errors: {},
      loading: true,
      submiting: false,
      submitingDestroy: false
    };
  },
  mounted() {
    this.getSupplier();
    console.log("success");
  },
  methods: {
    getSupplier() {
      this.loading = true;
      let str = window.location.pathname;
      let res = str.split("/");
      axios
        .get(`/api/suppliers/getSupplier/${res[2]}`)
        .then(response => {
          this.supplier = response.data;
        })
        .catch(error => {
          this.$toasted.global.error("El proveedor no existe!");
          location.href = "/suppliers";
        })
        .then(() => {
          this.loading = false;
        });
    },

    update() {
      if (!this.submiting) {
        this.submiting = true;
        axios
          .put(`/api/suppliers/update/${this.supplier.id}`, this.supplier)
          .then(response => {
            this.$toasted.global.error("Proveedor actualizado!");
            location.href = "/suppliers";
          })
          .catch(error => {
            this.errors = error.response.data.errors;
            this.submiting = false;
          });
      }
    },
    destroy() {
      if (!this.submitingDestroy) {
        this.submitingDestroy = true;
        swal({
          title: "¿Esta usted seguro?",
          text: "Usted esta por borrar este proveedor!",
          icon: "warning",
          buttons: true,
          dangerMode: true
        }).then(willDelete => {
          if (willDelete) {
            axios
              .delete(`/api/suppliers/${this.supplier.id}`)
              .then(response => {
                this.$toasted.global.error("Proveedor eliminado!");
                location.href = "/suppliers";
              })
              .catch(error => {
                this.errors = error.response.data.errors;
              });
          }
          this.submitingDestroy = false;
        });
      }
    }
  }
};
</script>
