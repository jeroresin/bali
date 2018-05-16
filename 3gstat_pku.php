

 
    <!-- memasukan jquery sebagai plugin tambahan -->

 
    <!-- membuat fungsi untuk menampilkan diagram batang ke dalam <div id="suara"></div> -->
    <script type="text/javascript">


	
    $(document).ready(function() {
        $('#suara').highcharts({
            chart: {
				
                type: 'pie',
                options3d: {
                    enabled: false,
                    alpha: 45
                }
            },
			exporting: {
        buttons: {
            contextButtons: {
                enabled: false,
                menuItems: null
            }
        },
        enabled: false
    }, 
            title: {
                text: null
            },
            subtitle: {
                text: null
            },
            plotOptions: {
			series: {
                dataLabels: {
                    enabled: true,
				
                    formatter: function() {
                        return '<span style="color:' + this.point.color + '"; "fontsize:25px">' + this.point.name + ' : ' + Math.round(this.percentage*100)/100 + ' %' + '</span>';
                    },
                    distance: -85
					
                }
            },
                pie: {
				size: 240,
                    innerSize: 180,
                    depth: 45
                }
            },
            series: [{  
                name: 'Count Of Swap Sites',
					colors: ['#FA5858', '#7d9bdd'],
                data: [ 
                  <?php
         class Connection {
    public function __construct() {
        // melakukan koneksi ke database
        $this->db = new PDO('mysql:host=31.220.57.21;dbname=swap_sumatera','ibnu','pascal');
        // urutannya adalah host;namadatabase;username;password
    }
 
    public function getswap() {
        // menampilkan seluruh data pada tabel hasilvoting
        $sql = "SELECT status,total FROM swap_status_global WHERE tech='3G' AND Region='Sumbagteng'";
        $query = $this->db->query($sql);
        return $query;
    }
}
 
                  // meng extend class Connection()
                $con = new Connection();
                 
                // mendapatkan seluruh data dari tabel hasilvoting kemudian di looping menggunakan while
                $stat = $con->getswap();
 
                // melakukan looping
                  while ($data = $stat->fetch(PDO::FETCH_OBJ)) {
                    echo "[ '".$data->status."', ".$data->total."],";
                  }
                  ?> 
                  ]  
            }]
        });
    });
    </script>
