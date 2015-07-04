# Jak zrobić sticky footer w naszym projekcie

### HTML file

1. footer wyciągnąć na szczyt drzewa tak, aby wyglądało ono jak poniżej:
<br>
body
<br>&nbsp;&nbsp;div.container
<br>&nbsp;&nbsp;div#footer

2. div#footer zamienić na footer#footer, czyli zamiast 
```HTML
<div id=footer>
``` 
napisać 
```HTML
<footer id="footer">
```

3. Wnętrze footera zrobić w sposób następujący:
footer#footer
	div.container
		p.text-muted
			wnętrze stopki (tańczącekotki itd)
			


### CSS file

1. Wkleić:

```CSS
/* Sticky footer styles
-------------------------------------------------- */
html {
  position: relative;
  min-height: 100%;
}
body {
  /* Margin bottom by footer height */
  margin-bottom: 60px;
}
.footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  /* Set the fixed height of the footer here */
  height: 60px;
  background-color: #f5f5f5;
}
```

1a. Jeśli nie zadziała to po wszystkich wartościach umieścić !important aż do skutku
