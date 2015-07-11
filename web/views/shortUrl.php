       <form action="javascript:request_set()">
            <table>
                <tr>
                    <th>Long URL</th>
                    <th>Short URL</th>
                </tr>
                <tr>
                    <td>
                        <input id="input_url" type="url" name="url">
                        <input type="submit" value="Do!">
                    </td>
                    <td id="url"></td>
                </tr>
            </table>
        </form>
        <footer>
			<pre>
				<div id='c_header' class='body_c'>
					<div id='message'><?= $message ?></div>
				</div>
			</pre>
        </footer>