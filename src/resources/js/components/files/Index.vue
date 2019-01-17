<template>
  <div class="container">
    <div class="card-header px-0 mt-2 bg-transparent clearfix">
      <h4 class="float-left pt-2">Archivos de Datos</h4>
      <div class="card-header-actions mr-1">
        <!-- <a class="btn btn-success" href="/files/create">Nuevo Archivo</a> -->
      </div>
    </div>
    <div class="card-body px-0">
      <div class="row justify-content-between">
        <div class="col-7 col-md-5">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" @click="filter">
                <i class="fas fa-search"></i>
              </span>
            </div>
            <input
              type="text"
              class="form-control"
              placeholder="Seach"
              v-model.trim="filters.search"
              @keyup.enter="filter"
            >
          </div>
        </div>
        <div class="col-auto">
          <multiselect
            v-model="filters.supplier_id"
            :options="suppliers"
            @select="changeSupplier"
            placeholder="Todos"
            label="name"
            track-by="id"
          ></multiselect>
        </div>
        <div class="col-auto">
          <multiselect
            v-model="filters.pagination.per_page"
            :options="[25,50,100,200]"
            :searchable="false"
            :show-labels="false"
            :allow-empty="false"
            @select="changeSize"
          ></multiselect>
        </div>
      </div>
      <table class="table table-hover">
        <thead>
          <tr>
            <th class="d-none d-sm-table-cell">
              <a href="#" class="text-dark" @click.prevent="sort('id')">ID</a>
              <i
                class="mr-1 fas"
                :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'id' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'id' && filters.orderBy.direction == 'desc'}"
              ></i>
            </th>
            <th>
              <a href="#" class="text-dark" @click.prevent="sort('fileName')">Archivo</a>
              <i
                class="mr-1 fas"
                :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'fileName' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'fileName' && filters.orderBy.direction == 'desc'}"
              ></i>
            </th>
            <th>Proveedor</th>
            <th>Nro Cliente</th>
            <th>Nombre Cliente</th>
            <th>Fecha Factura</th>
            <th>Estado</th>
            <th>Lineas</th>
            <th class="d-none d-sm-table-cell">
              <a href="#" class="text-dark" @click.prevent="sort('created_at')">Regsitrado</a>
              <i
                class="mr-1 fas"
                :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'created_at' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'created_at' && filters.orderBy.direction == 'desc'}"
              ></i>
            </th>
            <th class="d-none d-sm-table-cell"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="file in files" :key="file.id">
            <td class="d-none d-sm-table-cell">{{file.id}}</td>
            <td>{{file.fileName}}</td>
            <td>{{file.supplier.name}}</td>
            <td>{{file.custNumber}}</td>
            <td>{{file.custName}}</td>
            <td>{{file.invoiceDate}}</td>
            <td>{{file.status}}</td>
            <td>{{file.bodies_count}}</td>
            <td class="d-none d-sm-table-cell">
              <small>{{file.created_at | moment("LL")}}</small> -
              <small class="text-muted">{{file.created_at | moment("LT")}}</small>
            </td>
            <td class="d-none d-sm-table-cell">
              <!-- <a href="#" class="text-muted" @click="editFile(file.id)">
                <i class="fas fa-pencil-alt"></i>
              </a>-->
            </td>
          </tr>
        </tbody>
      </table>
      <div class="row" v-if="!loading && filters.pagination.total > 0">
        <div
          class="col pt-2"
        >{{filters.pagination.from}}-{{filters.pagination.to}} of {{filters.pagination.total}}</div>
        <div class="col" v-if="filters.pagination.last_page>1">
          <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end">
              <li class="page-item" :class="{'disabled': filters.pagination.current_page <= 1}">
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="changePage(filters.pagination.current_page -  1)"
                >
                  <i class="fas fa-angle-left"></i>
                </a>
              </li>
              <li
                class="page-item"
                v-for="page in filters.pagination.last_page"
                :class="{'active': filters.pagination.current_page == page}"
                :key="page"
              >
                <span class="page-link" v-if="filters.pagination.current_page == page">{{page}}</span>
                <a class="page-link" href="#" v-else @click.prevent="changePage(page)">{{page}}</a>
              </li>
              <li
                class="page-item"
                :class="{'disabled': filters.pagination.current_page >= filters.pagination.last_page}"
              >
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="changePage(filters.pagination.current_page +  1)"
                >
                  <i class="fas fa-angle-right"></i>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <div class="no-items-found text-center mt-5" v-if="!loading && !files.length > 0">
        <i class="icon-magnifier fa-3x text-muted"></i>
        <p class="mb-0 mt-3">
          <strong>No hay archivos registrados</strong>
        </p>
        <p class="text-muted">Intente cambiar los criterios de filtrado</p>
        <!-- <a class="btn btn-success" href="/files/create" role="button">
          <i class="fa fa-plus"></i>&nbsp; Nuevo Archivo
        </a>-->
      </div>
      <content-placeholders v-if="loading">
        <content-placeholders-text/>
      </content-placeholders>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      files: [],
      suppliers: [],
      loading: true,
      filters: {
        pagination: {
          from: 0,
          to: 0,
          total: 0,
          per_page: 25,
          current_page: 1,
          last_page: 0
        },
        orderBy: {
          column: "id",
          direction: "asc"
        },
        search: "",
        supplier_id: []
      }
    };
  },
  mounted() {
    if (localStorage.getItem("filtersTableSuppliers")) {
      this.filters = JSON.parse(localStorage.getItem("filtersTableSuppliers"));
    } else {
      localStorage.setItem("filtersTableSuppliers", this.filters);
    }
    this.getSuppliers();
    this.getFiles();
  },
  methods: {
    getSuppliers() {
      this.loading = true;
      this.suppliers = [];

      axios.get("/api/suppliers").then(response => {
        this.suppliers = response.data;
      });
    },
    getFiles() {
      this.loading = true;
      this.files = [];

      localStorage.setItem(
        "filtersTableSuppliers",
        JSON.stringify(this.filters)
      );

      axios
        .post(
          `/api/files/filter?page=${this.filters.pagination.current_page}`,
          this.filters
        )
        .then(response => {
          this.files = response.data.data;
          delete response.data.data;
          this.filters.pagination = response.data;
          this.loading = false;
        });
    },
    editFile(fileId) {
      location.href = `/files/${fileId}/edit`;
    },
    // filters
    filter() {
      this.filters.pagination.current_page = 1;
      this.getFiles();
    },
    changeSize(perPage) {
      this.filters.pagination.current_page = 1;
      this.filters.pagination.per_page = perPage;
      this.getFiles();
    },
    changeSupplier(supplier) {
      this.filters.supplier_id = supplier;
      this.getFiles();
    },
    sort(column) {
      if (column == this.filters.orderBy.column) {
        this.filters.orderBy.direction =
          this.filters.orderBy.direction == "asc" ? "desc" : "asc";
      } else {
        this.filters.orderBy.column = column;
        this.filters.orderBy.direction = "asc";
      }

      this.getFiles();
    },
    changePage(page) {
      this.filters.pagination.current_page = page;
      this.getFiles();
    }
  }
};
</script>
