var commands = [];
var current = null;
var list = getCmdOut('php "$TM_BUNDLE_SUPPORT/GUI\ Scripts/cli.php"');

$(document).ready(function() {

  $('tasks > task', list).each(function(i, el) {
    var task = $(el);
      if ('_global' != task.attr('namespace')) {
      commands[i] = {
        cmd: task.attr('namespace') + ':' + task.attr('name'),
        description: $('description', task).html(),
        help: $('help', task).html()
      };
    } else {
      commands[i] = {
        cmd: task.attr('name'),
        description: $('description', task).html(),
        help: $('help', task).html()
      };
    }
  });

  $("#command").autocomplete(commands, {
    scroll: true,
    formatItem: function(row, i, max) {
      return row.cmd + '<div class="description">' + row.description + "</div>";
    },
    formatMatch: function(row, i, max) {
      return row.cmd;
    },
    formatResult: function(row) {
      return row.cmd;
    }
  })
  .focus()
  .result(findValueCallback);

  $('form').submit(function() {
    var ret = getCmdRet(
      'php "$TM_BUNDLE_SUPPORT/GUI\ Scripts/cli.php" cmd "' + $('#command').val() + '" && rescan_project'
    );
    $('#output').removeClass('error').hide()

    if (ret.outputString) {
      $('#help').hide();
      $('#output').show().html(ret.outputString);
      $('#command').val('');
    } else if (ret.errorString) {
      $('#help').hide();
      $('#output').addClass('error').show().html(ret.errorString);
    }

    return false;
  });
});

function findValueCallback(event, data, formatted) {
  $('#help').hide();
  $('#output').hide();

  if (data.help) {
    $('#help').show().html(
      data.help.replace(/\&lt\;/g, '<').replace(/\&gt\;/g, '>').replace(/\n/g, '<br />')
    );
  }
}

function getCmdRet(cmd) {
  TextMate.isBusy = true;
  var out = TextMate.system(cmd, null);
  TextMate.isBusy = false;

  return out;
}

function getCmdOut(cmd) {
  return getCmdRet(cmd).outputString;
}