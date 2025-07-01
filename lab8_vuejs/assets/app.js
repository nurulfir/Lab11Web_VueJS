const { createApp } = Vue;

const apiUrl = 'http://localhost/lab11_ci/ci4/public';

createApp({
  data() {
    return {
      artikel: [],
      formData: {
        id: null,
        judul: '',
        isi: '',
        status: 0,
      },
      showForm: false,
      formTitle: 'Tambah Data',
      statusOptions: [
        { text: 'Draft', value: 0 },
        { text: 'Publish', value: 1 },
      ],
    };
  },
  mounted() {
    this.loadData();
  },
  methods: {
    loadData() {
      axios
        .get(apiUrl + '/post')
        .then((response) => {
          this.artikel = response.data.artikel.map((item) => ({
            ...item,
            status: Number(item.status),
          }));
        })
        .catch((error) => console.error('Error:', error));
    },
    tambah() {
      this.showForm = true;
      this.formTitle = 'Tambah Data';
      this.formData = {
        id: null,
        judul: '',
        isi: '',
        status: 0,
      };
    },
    edit(data) {
      this.showForm = true;
      this.formTitle = 'Ubah Data';
      this.formData = {
        id: data.id,
        judul: data.judul,
        isi: data.isi,
        status: Number(data.status),
      };
    },
    hapus(index, id) {
      if (confirm('Yakin menghapus data?')) {
        axios
          .delete(apiUrl + '/post/' + id)
          .then(() => {
            this.artikel.splice(index, 1);
          })
          .catch((error) => console.error('Error:', error));
      }
    },
    saveData() {
      this.formData.status = Number(this.formData.status);

      const request = this.formData.id
        ? axios.put(apiUrl + '/post/' + this.formData.id, this.formData)
        : axios.post(apiUrl + '/post', this.formData);

      request
        .then((response) => {
          if (this.formData.id) {
            const index = this.artikel.findIndex(
              (item) => item.id === this.formData.id
            );
            if (index !== -1) {
              this.artikel[index] = { ...this.formData };
            }
          } else {
            this.loadData();
          }
        })
        .catch((error) => {
          console.error('Error:', error.response?.data || error.message);
          alert('Error: ' + (error.response?.data?.message || error.message));
        })
        .finally(() => {
          this.showForm = false;
        });
    },
    statusText(status) {
      const numStatus = Number(status);
      return numStatus === 1 ? 'Publish' : 'Draft';
    },
    statusClass(status) {
      return Number(status);
    },
  },
}).mount('#app');
