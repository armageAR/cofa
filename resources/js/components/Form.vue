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

export class Form {
  /**
   * Create a new Form instance.
   *
   * @param {object} data
   */
  constructor(data) {
    this.originalData = data;

    for (let field in data) {
      this[field] = data[field];
    }

    this.errors = new Errors();
  }
  /**
   * Fetch all relevant data for the form.
   */
  data() {
    let data = {};

    for (let property in this.originalData) {
      data[property] = this[property];
    }

    return data;
  }

  update(url) {
    return new Promise((resolve, reject) => {
      axios
        .put(url, {
          supplier: this.supplier,
          address: this.address,
          contact: this.contact
        })
        .then(response => {
          resolve(response.data);
        })
        .catch(error => {
          this.errors.record(error.response.data.errors);
        });
    });
  }
  create(url) {
    return new Promise((resolve, reject) => {
      axios
        .post(url, {
          supplier: this.supplier,
          address: this.address,
          contact: this.contact
        })
        .then(response => {
          resolve(response.data);
        })
        .catch(error => {
          this.errors.record(error.response.data.errors);
        });
    });
  }
  destroy(url) {
    swal({
      title: "¿Esta usted seguro?",
      text: "Usted esta por borrar este proveedor!",
      icon: "warning",
      buttons: true,
      dangerMode: true
    }).then(willDelete => {
      if (willDelete) {
        axios
          .delete(url)
          .then(response => {
            location.href = "/suppliers";
          })
          .catch(error => {
            this.errors.record(error.response.data.errors);
          });
      }
    });
  }
}
</script>
