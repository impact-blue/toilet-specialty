<?php
  $area_name = get_area_name();

  $fields = get_field('answer_data');
  if($fields) {
    $pie_graph_data = array_values($fields['price_range']);
    $bar_graph_own_data = $fields['repair_rate']['own'];
    $bar_graph_request_data = $fields['repair_rate']['request'];

    arsort($fields['price_range']);
    $pie_graph_first_key = array_keys($fields['price_range'])[0];
    $pie_graph_second_key = array_keys($fields['price_range'])[1];
    $pie_graph_first_label = acf_get_field($pie_graph_first_key )['label'];
    $pie_graph_second_label = acf_get_field($pie_graph_second_key)['label'];
    $pie_graph_first_value = array_shift($fields['price_range']);
    $pie_graph_second_value = array_shift($fields['price_range']);

    $price_range_data = (5 === count(array_filter($pie_graph_data)));
  }

  $item_name = get_item_name();
?>

<?php if ($fields && $price_range_data && $bar_graph_own_data && $bar_graph_request_data ) { ?>
<section class="questionnaire-graph">
  <div class="inner">
    <h2 class="area-ttl"><?= $area_name ?>の<span><?= $item_name ?>修理料金相場</span>と<span>業者への依頼割合</span></h2>
    <div class="questionnaire-background">
      <div class="questionnaire-content">
        <div class="graph">
          <div class="piechart-wrap">
            <h3 class="piechart-ttl"><?= $item_name ?>料金割合</h3>
            <div class="chart-container">
              <canvas id="PieChart"></canvas>
            </div>
          </div>
          <div class="stickchart-wrap">
            <h3 class="stickchart-ttl"><?= $item_name ?>を自分で修理・業者に依頼の割合</h3>
            <div class="chart-container bar-graph">
              <canvas id="StickChart"></canvas>
            </div>
          </div>
        </div>
        <div class="questionnaire-txt">
          <p><?= $area_name ?>の<?= $item_name ?>料金は<?= $pie_graph_first_label ?>の範囲内が<?= $pie_graph_first_value ?>%と一番多く、次に<?= $pie_graph_second_label ?>が<?= $pie_graph_second_value ?>%となりました。また、<?= $item_name ?>を自分で修理する人は<?= $bar_graph_own_data ?>%となっており、業者に依頼する人が<?= $bar_graph_request_data ?>%と多くの人が業者に依頼しています。<br><br><?= $item_name ?>の原因で軽度のものはラバーカップを使うことで解決できますが、多くの場合はラバーカップでの解決が難しく業者に依頼する人が多いです。</p>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
  const pie_value = <?= json_encode($pie_graph_data) ?>;
  const bar_graph_own_value = <?= json_encode($bar_graph_own_data) ?>;
  const bar_graph_request_value = <?= json_encode($bar_graph_request_data) ?>;
  const PieChartCtx = document.getElementById("PieChart");
  const PieChart = new Chart(PieChartCtx, {
    type: 'pie',
    data: {
      labels: ["10,000円以下", "10,000円〜30,000円", "30,000円〜50,000円", "50,000円〜100,000円", "100,000円以上"],
      datasets: [{
        backgroundColor: ["#C3F8FF", "#A7E1FF", "#8BC3FF", "#81A5FF", "#4B87FF"],
        data: pie_value,
      }]
    },
    plugins: [
      ChartDataLabels,
    ],
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
        datalabels: {
          anchor: 'end',
          color: 'black',
          align: 'end',
          textAlign: 'center',
          font: {
            size: '10',
          },
          formatter: (value, ctx) => {
            let label = ctx.chart.data.labels[ctx.dataIndex];
            return label + '\n' + value + '%';
          },
        },
        tooltip: {
          callbacks: {
            label: (context) => {
              return `${context.label}: ${context.formattedValue}%`;
            }
          }
        }
      },
      layout: {
        padding: {
          top: 35,
          right: 85,
          bottom: 35,
          left: 85
        }
      }
    }
  });
  const StickChartCtx = document.getElementById("StickChart");
  const StickChart = new Chart(StickChartCtx, {
    type: 'bar',
    data: {
      labels: [''],
      datasets: [{
        label: "自分で修理",
        data: [bar_graph_own_value],
        backgroundColor: '#C3F8FF'
      },{
        label: "業者に依頼",
        data: [bar_graph_request_value],
        backgroundColor: '#A7E1FF'
      }]
    },
    options: {
      indexAxis: 'y',
      scales: {
        x: {
          stacked: true,
        },
        y: {
          stacked: true
        },
      },
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        tooltip: {
          callbacks: {
            label: (context) => {
              return `${context.dataset.label}: ${context.formattedValue}%`;
            }
          }
        }
      }
    }
  });
</script>
<?php } ?>