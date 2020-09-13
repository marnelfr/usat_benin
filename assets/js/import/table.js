import dt from 'datatables.net-bs4';
dt(window, $);

export default class Table {
  options
  table

  constructor(table_selector = '.datatable') {
    this.table = $(table_selector);
  }

  DataTable() {
    this.dataTableOption()
    this.table.DataTable(this.options)
  }


  dataTableOption() {
    this.options = {
      'paging': true,
      'lengthChange': false,
      'pageLength': 10,
      'searching': false,
      'ordering': false,
      'info': true,
      'autoWidth': false,
      "language": {
        "pageLength": 5,
        "lengthMenu": "Afficher _MENU_ lignes par page",
        "zeroRecords": "Désolé rien a été trouvé",
        "info": "Page _PAGE_ sur _PAGES_",
        "infoEmpty": "Aucune donnée disponible",
        "infoFiltered": "(filtered from _MAX_ total records)",
        "search": "Rech.:",
        "paginate": {
          "previous": "Précédent",
          "next": "Suivant"
        }
      }
    }
  }

}
