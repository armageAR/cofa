<template src="./form.html"></template>

<script>
class Errors {
  constructor() {
    this.errors = {};
  }

  get(field) {
    if (this.errors[field]) {
      return this.errors[field][0];
    }
  }

  record(errors) {
    this.errors = errors;
  }
}
export default {
  data() {
    return {
      supplier: {},
      address: {},
      contact: {},
      errors: new Errors(),
      loading: true,
      submiting: false,
      submitingDestroy: false,
      createForm: false
    };
  },
  mounted() {
    this.getSupplier();
  },
  methods: {
    getSupplier() {
      this.loading = true;
      let str = window.location.pathname;
      let res = str.split("/");
      axios
        .get(`/api/suppliers/${res[2]}`)
        .then(response => {
          console.log(response);
          this.supplier = response.data;
          if (this.supplier.addresses.length > 0) {
            this.address = this.supplier.addresses[0];
          }
          if (this.supplier.contacts.length > 0) {
            this.contact = this.supplier.contacts[0];
          }
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
          .put(`/api/suppliers/update/${this.supplier.id}`, {
            supplier: this.supplier,
            address: this.address,
            contact: this.contact
          })
          .then(response => {
            this.$toasted.global.error("Proveedor actualizado!");
            location.href = "/suppliers";
          })
          .catch(error => {
            this.errors.record(error.response.data.errors);
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
