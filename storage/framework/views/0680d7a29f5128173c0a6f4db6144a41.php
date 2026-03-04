<?php $__env->startSection('title','Laporan Keuangan | Admin'); ?>

<?php $__env->startSection('content'); ?>

<style>
.laporan-page .content-header{
  display:flex;
  align-items:center;
  gap:10px;
  margin-bottom:15px;
}

.laporan-page h3{
  margin:0;
  font-size:20px;
}

.laporan-page .filter{
  display:flex;
  align-items:center;
  justify-content:space-between;
  flex-wrap:wrap;
  gap:10px;
  margin-bottom:15px;
}

.laporan-page .filter-buttons{
  display:flex;
  gap:6px;
  flex-wrap:wrap;
}

.laporan-page .filter button{
  padding:8px 14px;
  border-radius:8px;
  border:none;
  cursor:pointer;
  font-size:13px;
  background:#e5e7eb;
  color:#374151;
}

.laporan-page .filter button.active{
  background:#2563eb;
  color:white;
}

.laporan-page .btn-export{
  padding:8px 14px;
  border-radius:8px;
  border:none;
  cursor:pointer;
  font-size:13px;
  background:#2563eb;
  color:white;
}

.laporan-page .card{
  background:white;
  border-radius:14px;
  padding:20px;
  box-shadow:0 10px 30px rgba(0,0,0,0.08);
}
</style>

<div class="laporan-page">
  <div class="content-header">
    <h3>📊 Laporan Keuangan</h3>
  </div>

  <div class="filter">
    <div class="filter-buttons">
      <button class="active" onclick="loadData('bulan',this)">Per Bulan</button>
      <button onclick="loadData('hari',this)">Per Hari</button>
      <button onclick="loadData('tahun',this)">Per Tahun</button>
    </div>

    <form method="POST"
          action="<?php echo e(route('admin.laporan.export')); ?>"
          target="_blank">
      <?php echo csrf_field(); ?>

      <input type="hidden" name="type" id="exportType" value="bulan">
      <button type="submit" class="btn-export">⬇ Export PDF</button>
    </form>
  </div>

  <div class="card">
    <canvas id="chart" height="90"></canvas>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let chart = null;

const ctx = document.getElementById('chart').getContext('2d');

function loadData(type, btn){
  document.querySelectorAll('.filter button')
    .forEach(b => b.classList.remove('active'));

  if(btn){
    btn.classList.add('active');
  }

  document.getElementById('exportType').value = type;

  fetch(`<?php echo e(route('admin.laporan.data')); ?>?type=` + type)
    .then(response => {
      if(!response.ok){
        throw new Error('Network error');
      }
      return response.json();
    })
    .then(data => {
      const labels = data.map(x => x.label);
      const values = data.map(x => x.total);

      if(chart){
        chart.destroy();
      }

      chart = new Chart(ctx,{
        type:'line',
        data:{
          labels: labels,
          datasets:[{
            label:'Total Penjualan (Rp)',
            data: values,
            borderColor:'#2563eb',
            backgroundColor:'rgba(37,99,235,0.15)',
            fill:true,
            tension:0.4,
            pointRadius:4
          }]
        },
        options:{
          responsive:true,
          plugins:{
            legend:{
              display:true
            }
          },
          scales:{
            y:{
              beginAtZero:true,
              ticks:{
                callback:function(value){
                  return 'Rp ' + value.toLocaleString('id-ID');
                }
              }
            }
          }
        }
      });

      if(labels.length === 0){
        chart.destroy();
        ctx.font = '16px Arial';
        ctx.fillText('Tidak ada data laporan', 10, 50);
      }
    })
    .catch(error => {
      console.error(error);
      alert('Gagal memuat data laporan');
    });
}

// load default

document.addEventListener('DOMContentLoaded', function(){
  loadData('bulan', document.querySelector('.filter button'));
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/KOPERASIINTERNAL/resources/views/admin/laporan.blade.php ENDPATH**/ ?>