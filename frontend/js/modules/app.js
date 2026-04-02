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
        loading: false,
        error: null,
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
      // I reset filters and reload the list when switching tabs
      switchTab(tab) {
        this.currentTab = tab;
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
    },
  }).mount('#app');
}

function handleError(err) {
  this.error = err.message;
}
