       <form action="javascript:request_set()">
            <table>
                <tr>
                    <th>Long URL</th>
                    <th>Short URL</th>
                </tr>
                <tr>
                    <td>
                        <input id="url" type="url" name="url">
                        <input type="submit" value="Do!">
						<input id="key" type="hidden" value="<?= $outKey ?>">
                    </td>
                    <td id=result><?= $outPut ?></td>
                </tr>
            </table>
        </form>
