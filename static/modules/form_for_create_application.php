<div class="form flex-column-center">
    <form class="flex-column-center" action="/static/index.php?page=applications&mode=create_application" method="POST">
        <input type="text" name="child-name" placeholder="Имя ребёнка" required>
        <input type="text" name="child-surname" placeholder="Фамилия ребёнка" required>
        <input type="text" name="child-patronymic" placeholder="Отчество ребёнка">
        <div class="input-label flex-row-center">
            <label for="child-birthdate">День рождения ребёнка:</label>
            <input type="date" name="child-birthdate" id="child-birthdate" required>
        </div>
        <input type="text" name="parent-name" placeholder="Имя родителя" required>
        <input type="text" name="parent-surname" placeholder="Фамилия родителя" required>
        <input type="text" name="parent-patronymic" placeholder="Отчество родителя">
        <input type="text" name="parent-phone" placeholder="Номер телефона родителя" required>
        <input type="text" name="parent-email" placeholder="Почта родителя" required>
        <input type="text" name="address" placeholder="Адрес проживания" required>
        <select name="desired_group">
            <option value="">Выберите группу</option>
            <option value="младшая группа">Младшая группа</option>
            <option value="средняя группа">Средняя группа</option>
            <option value="старшая группа">Старшая группа</option>
        </select>
        <button type="submit">Подать заявление</button>
    </form>
    <p>*Заявление будет рассмотрено администратором.</p>
</div>