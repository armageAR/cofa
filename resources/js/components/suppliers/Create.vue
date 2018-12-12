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
      submiting: false,
      createForm: true
    };
  },
  mounted() {},
  methods: {
    create() {
      if (!this.submiting) {
        this.submiting = true;
        axios
          .post(`/api/suppliers/store`, {
            supplier: this.supplier,
            address: this.address,
            contact: this.contact
          })
          .then(response => {
            this.$toasted.global.error("Proveedor creado!");
            location.href = "/suppliers";
          })
          .catch(error => {
            //console.log(error.response.data.errors);
            this.errors.record(error.response.data.errors);
            this.submiting = false;
          });
      }
    }
  }
};
</script>
