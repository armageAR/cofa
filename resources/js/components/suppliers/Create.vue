<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-10">
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
            <label>Nombre Comercial</label>
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

          <fieldset class="form-group fieldset1">
            <legend class="legend1">Dirección</legend>
            <div class="form-group">
              <div class="row">
                <div class="col-8">
                  <label>Calle</label>
                  <input
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': errors.street}"
                    v-model="supplier.street"
                  >
                  <div class="invalid-feedback" v-if="errors.street">{{errors.street[0]}}</div>
                </div>
                <div class="col-2">
                  <label>Número</label>
                  <input
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': errors.number}"
                    v-model="supplier.number"
                  >
                  <div class="invalid-feedback" v-if="errors.number">{{errors.number[0]}}</div>
                </div>
                <div class="col-2">
                  <label>Depto</label>
                  <input
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': errors.department}"
                    v-model="supplier.department"
                  >
                  <div class="invalid-feedback" v-if="errors.department">{{errors.department[0]}}</div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label>Provincia</label>
              <input
                type="text"
                class="form-control"
                :class="{'is-invalid': errors.state}"
                v-model="supplier.state"
              >
              <div class="invalid-feedback" v-if="errors.state">{{errors.state[0]}}</div>
            </div>

            <div class="form-group">
              <div class="row">
                <div class="col-9">
                  <label>Ciudad</label>
                  <input
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': errors.city}"
                    v-model="supplier.city"
                  >
                  <div class="invalid-feedback" v-if="errors.city">{{errors.city[0]}}</div>
                </div>
                <div class="col-3">
                  <label>Código Postal</label>
                  <input
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': errors.zip}"
                    v-model="supplier.zip"
                  >
                  <div class="invalid-feedback" v-if="errors.zip">{{errors.zip[0]}}</div>
                </div>
              </div>
            </div>
          </fieldset>

          <br>

          <fieldset class="form-group fieldset1">
            <legend class="legend1">Contacto</legend>
            <div class="form-group">
              <div class="row">
                <div class="col-6">
                  <label>Primer Nombre</label>
                  <input
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': errors.first_name}"
                    v-model="supplier.first_name"
                  >
                  <div class="invalid-feedback" v-if="errors.first_name">{{errors.first_name[0]}}</div>
                </div>
                <div class="col-6">
                  <label>Segundo Nombre</label>
                  <input
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': errors.middle_name}"
                    v-model="supplier.middle_name"
                  >
                  <div class="invalid-feedback" v-if="errors.middle_name">{{errors.middle_name[0]}}</div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label>Apellido</label>
              <input
                type="text"
                class="form-control"
                :class="{'is-invalid': errors.last_name}"
                v-model="supplier.last_name"
              >
              <div class="invalid-feedback" v-if="errors.last_name">{{errors.last_name[0]}}</div>
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

            <div class="form-group">
              <label>Celular</label>
              <input
                type="text"
                class="form-control"
                :class="{'is-invalid': errors.mobile}"
                v-model="supplier.mobile"
              >
              <div class="invalid-feedback" v-if="errors.mobile">{{errors.mobile[0]}}</div>
            </div>

            <div class="form-group">
              <label>Fax</label>
              <input
                type="text"
                class="form-control"
                :class="{'is-invalid': errors.fax}"
                v-model="supplier.fax"
              >
              <div class="invalid-feedback" v-if="errors.fax">{{errors.fax[0]}}</div>
            </div>

            <div class="form-group">
              <label>E-Mail</label>
              <input
                type="text"
                class="form-control"
                :class="{'is-invalid': errors.email}"
                v-model="supplier.email"
              >
              <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
            </div>

            <div class="form-group">
              <label>Website</label>
              <input
                type="text"
                class="form-control"
                :class="{'is-invalid': errors.website}"
                v-model="supplier.website"
              >
              <div class="invalid-feedback" v-if="errors.website">{{errors.website[0]}}</div>
            </div>

            <div class="form-group">
              <label>Notas</label>
              <input
                type="textarea"
                class="form-control"
                :class="{'is-invalid': errors.notes}"
                v-model="supplier.notes"
              >
              <div class="invalid-feedback" v-if="errors.notes">{{errors.notes[0]}}</div>
            </div>
          </fieldset>
        </div>
        <div class="card-footer px-0 mt-2 bg-transparent clearfix">
          <a
            class="btn btn-primary float-right"
            href="#"
            :disabled="submiting"
            @click.prevent="create"
          >
            <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
            <i class="fas fa-check" v-else></i>
            <span class="ml-1">Grabar</span>
          </a>
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
