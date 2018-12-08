<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2">Nuevo Proveedor</h4>
          <div class="card-header-actions mr-1">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="create">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Grabar</span>
            </a>
          </div>
        </div>
        <div class="card-body px-0">
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
            <label>Nombre</label>
            <input
              type="text"
              class="form-control"
              :class="{'is-invalid': errors.name}"
              v-model="supplier.name"
            >
            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
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
            <label>Nombre</label>
            <input
              type="text"
              class="form-control"
              :class="{'is-invalid': errors.first_name}"
              v-model="supplier.first_name"
            >
            <div class="invalid-feedback" v-if="errors.first_name">{{errors.first_name[0]}}</div>
          </div>

          <div class="form-group">
            <label>Telefono</label>
            <input
              type="text"
              class="form-control"
              :class="{'is-invalid': errors.phone}"
              v-model="supplier.phone"
            >
            <div class="invalid-feedback" v-if="errors.phone">{{errors.phone[0]}}</div>
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
      submiting: false
    };
  },
  mounted() {},
  methods: {
    create() {
      if (!this.submiting) {
        this.submiting = true;
        axios
          .post(`/api/suppliers/store`, this.supplier)
          .then(response => {
            this.$toasted.global.error("Proveedor creado!");
            location.href = "/suppliers";
          })
          .catch(error => {
            this.errors = error.response.data.errors;
            this.submiting = false;
          });
      }
    }
  }
};
</script>
