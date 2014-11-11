var scheme_table_init_called = false;

function scheme_table_insertTextCell(row, content)
{
	cell = document.createElement('td');
	text = document.createTextNode(content);
	cell.appendChild(text);
	row.insertBefore(cell, row.firstChild);
}

function scheme_table_insertCell(row, content)
{
	cell = document.createElement('td');
	cell.appendChild(content);
	row.insertBefore(cell, row.firstChild);
}

function scheme_table_onClick(obj, table)
{	
	var boxes = table.getElementsByTagName('input');

	for (var i = 0;i < boxes.length; i++)
		if (Element.hasClassName(boxes[i], 'scheme_table_checkbox')) boxes[i].checked = obj.checked;
}

function scheme_table_addSelectCells(table)
{
	var rows = table.getElementsByTagName('tr');

	for (var i = 0;i < rows.length - 1; i++)
	{
		var inputs = rows[i].getElementsByTagName('input');
		var input = null;

		for (var j = 0;j < inputs.length;j++)
		{
			if (inputs[j].type == 'checkbox')
			{
				input = inputs[j];
				break;
			}
		}
		
		if (i == 0) Event.observe(input, 'click', function(e) { scheme_table_onClick(this, table);});
		if (i > 0) Element.addClassName(input, 'scheme_table_checkbox');

		if (rows[i].cells.length == 1 && rows[i].cells[0].hasAttribute('colspan') && rows[i].cells[0].getAttribute('colspan') == 0)
			continue;
		
		if (i == 0) scheme_table_insertTextCell(rows[i], '#');
		else scheme_table_insertTextCell(rows[i], i);
	}
}

function scheme_table_init(params)
{
	if (params == null) params = Array();

	if (scheme_table_init_called) return;
	else scheme_table_init_called = true;

	var tables = document.getElementsByClassName('scheme_table_inner');

	for (var i = 0;i < tables.length; i++)
	{
		if (params.select_cells) scheme_table_addSelectCells(tables[i]);
	
		var rows = tables[i].getElementsByTagName('tr');

		// Check if the first row is a table header. If no, make it one.
		if (!Element.hasClassName(rows[0], 'scheme_table_topbar')) Element.addClassName(rows[0], 'scheme_table_topbar');

		for (var j = 0;j < rows.length; j++)
		{		
			var cells = rows[j].getElementsByTagName('td');
			
			// Change all "colspan=0" attributes to numeric values - IE suxx...
			if (j > 0 && cells.length == 1 && rows.length > 1 && cells[0].hasAttribute('colspan') && cells[0].getAttribute('colspan') == 0)
			{
				cells[0].setAttribute('colspan', rows[0].cells.length);
			}

			if (Element.hasClassName(rows[j], 'scheme_table_topbar') || Element.hasClassName(rows[j], 'scheme_table_bottombar'))
			{
				if (cells.length > 1)
				{
					for (var k = 0;k < cells.length; k++)
					{
						if (k == 0)
							Element.setStyle(cells[k], {'border-right' : 0});
						else if (k == cells.length - 1)
							Element.setStyle(cells[k], {'border-left' : 0});
						else
							Element.setStyle(cells[k], {'border-left' : 0, 'border-right' : 0});

//						if (k < 2) Element.setStyle(cells[k], {'width' : '5px'});
						if (k < 2) Element.setStyle(cells[k], {'width' : 'auto'});
					}
				}
				continue;
			}
			
			if (j % 2 == 0) Element.addClassName(rows[j], 'scheme_table_inner_tr_white');
			Element.addClassName(rows[j], 'scheme_table_inner_tr');
		}
	}
}
