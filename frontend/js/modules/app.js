import { createApp } from 'vue';

export function app() {
  createApp({
    data() {
      return {
        authors: [],
        books: [],
        currentTab: 'authors',
        apiUrl: 'http://127.0.0.1:8000/api',
        searchQuery: '',
        authorIdFilter: '',
        minPriceFilter: '',
        selectedItem: null,
        loading: false,
        loadingDetail: false,
        error: null,
        newAuthor: { name: '', email: '', bio: '' },
        newBook: { title: '', pages: '', price: '', author_id: '' },
      };
    },

    computed: {
      currentList() {
        if (this.currentTab === 'authors') {
          return this.authors;
        }
        return this.books;
      },

      searchPlaceholder() {
        if (this.currentTab === 'authors') {
          return 'Search by name or bio...';
        }
        return 'Search by title...';
      },
    },

    created() {
      this.loadList();
    },

    methods: {
      switchTab(tab) {
        this.currentTab = tab;
        this.selectedItem = null;
        this.searchQuery = '';
        this.authorIdFilter = '';
        this.minPriceFilter = '';
        this.error = null;
        this.loadList();
      },

      loadList() {
        this.loading = true;
        this.error = null;

        const params = new URLSearchParams();

        if (this.searchQuery) {
          params.append('search', this.searchQuery);
        }
        if (this.currentTab === 'books' && this.authorIdFilter) {
          params.append('author_id', this.authorIdFilter);
        }
        if (this.currentTab === 'books' && this.minPriceFilter) {
          params.append('min_price', this.minPriceFilter);
        }

        const url = `${this.apiUrl}/${this.currentTab}?${params.toString()}`;

        fetch(url)
          .then(handleListResponse)
          .then(storeList.bind(this))
          .catch(handleError.bind(this))
          .finally(stopLoading.bind(this));

        function handleListResponse(res) {
          if (!res.ok) {
            throw new Error('Failed to load data. Is the server running?');
          }
          return res.json();
        }

        function storeList(data) {
          if (this.currentTab === 'authors') {
            this.authors = data;
          } else {
            this.books = data;
          }
        }

        function stopLoading() {
          this.loading = false;
        }
      },

      selectItem(id) {
        this.loadingDetail = true;
        this.selectedItem = null;
        this.error = null;

        fetch(`${this.apiUrl}/${this.currentTab}/${id}`)
          .then(handleDetailResponse)
          .then(storeDetail.bind(this))
          .catch(handleError.bind(this))
          .finally(stopDetailLoading.bind(this));

        function handleDetailResponse(res) {
          if (!res.ok) {
            throw new Error('Failed to load details.');
          }
          return res.json();
        }

        function storeDetail(data) {
          this.selectedItem = data;
          this.$nextTick(animateDetailPanel.bind(this));
        }

        function animateDetailPanel() {
          gsap.from(this.$refs.detailPanel, {
            opacity: 0,
            y: 20,
            duration: 0.8,
            ease: 'power2.out',
          });
        }

        function stopDetailLoading() {
          this.loadingDetail = false;
        }
      },

      closeDetail() {
        this.selectedItem = null;
      },

      deleteItem(id) {
        if (!confirm('Delete this item?')) {
          return;
        }
        this.error = null;

        fetch(`${this.apiUrl}/${this.currentTab}/${id}`, {
          method: 'DELETE',
        })
          .then(handleDeleteResponse.bind(this))
          .catch(handleError.bind(this));

        function handleDeleteResponse(res) {
          if (!res.ok) {
            throw new Error('Failed to delete item.');
          }
          if (this.selectedItem && this.selectedItem.id === id) {
            this.selectedItem = null;
          }
          this.loadList();
        }
      },
    },
  }).mount('#app');
}

function handleError(err) {
  this.error = err.message;
}
